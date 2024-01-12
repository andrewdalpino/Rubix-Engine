<?php

namespace Rubix\ML\Backends;

use Rubix\ML\Backends\Tasks\Task;
use Rubix\ML\Serializers\Serializer;
use Rubix\ML\Serializers\Igbinary;
use Rubix\ML\Serializers\Native;
use Rubix\ML\Specifications\ExtensionIsLoaded;
use Swoole\Process;

use function Swoole\Coroutine\run;

/**
 * Swoole
 *
 * Works both with Swoole and OpenSwoole.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 */
class Swoole implements Backend
{
    /**
     * The queue of tasks to be processed in parallel.
     */
    protected array $queue = [];

    private int $cpus;

    private Serializer $serializer;

    public function __construct(?Serializer $serializer = null)
    {
        $this->cpus = swoole_cpu_num();

        if ($serializer) {
            $this->serializer = $serializer;
        } else {
            if (ExtensionIsLoaded::with('igbinary')->passes()) {
                $this->serializer = new Igbinary();
            } else {
                $this->serializer = new Native();
            }
        }
    }

    /**
     * Queue up a deferred task for backend processing.
     *
     * @internal
     *
     * @param \Rubix\ML\Backends\Tasks\Task $task
     * @param callable(mixed,mixed):void $after
     * @param mixed $context
     */
    public function enqueue(Task $task, ?callable $after = null, $context = null) : void
    {
        $this->queue[] = function () use ($task, $after, $context) {
            $result = $task();

            if ($after) {
                $after($result, $context);
            }

            return $result;
        };
    }

    /**
     * Process the queue and return the results.
     *
     * @internal
     *
     * @return mixed[]
     */
    public function process() : array
    {
        $results = [];

        $workerProcesses = [];

        $currentCpu = 0;

        while (($queueItem = array_shift($this->queue))) {
            $workerProcess = new Process(
                function (Process $worker) use ($queueItem) {
                    $worker->exportSocket()->send(igbinary_serialize($queueItem()));
                },
                // redirect_stdin_and_stdout
                false,
                // pipe_type
                SOCK_STREAM,
                // enable_coroutine
                true,
            );

            $workerProcess->setAffinity([$currentCpu]);
            $workerProcess->setBlocking(false);
            $workerProcess->start();

            $workerProcesses[] = $workerProcess;

            $currentCpu = ($currentCpu + 1) % $this->cpus;
        }

        run(function () use (&$results, $workerProcesses) {
            foreach ($workerProcesses as $workerProcess) {
                $receivedData = $workerProcess->exportSocket()->recv();
                $unserialized = igbinary_unserialize($receivedData);

                $results[] = $unserialized;
            }
        });

        return $results;
    }

    /**
     * Flush the queue
     */
    public function flush() : void
    {
        $this->queue = [];
    }

    /**
     * Return the string representation of the object.
     *
     * @internal
     *
     * @return string
     */
    public function __toString() : string
    {
        return 'Swoole\\Process';
    }
}
