<?php

namespace Rubix\Engine\Persisters;

use InvalidArgumentException;
use RuntimeException;

class Filesystem implements Persister
{
    const MODE = 'wb+';

    /**
     * The path to the file in the filesystem.
     *
     * @var string
     */
    protected $path;

    /**
     * @param  string  $path
     * @return void
     */
    public function __construct(string $path)
    {
        if (!is_writable(dirname($path))) {
            throw new InvalidArgumentException('Folder does not exist or is not writeable.');
        }

        $this->path = $path;
    }

    /**
     * Save the persisable object to the Filesystem. Returns true on success, false on error.
     *
     * @return bool
     */
    public function save(Persistable $persistable) : bool
    {
        return file_put_contents($this->path, serialize($persistable), LOCK_EX) ? true : false;
    }

    /**
     * Restore the persistable object from the filesystem.
     *
     * @throws \RuntimeException
     * @return \Rubix\Engine\Persistable
     */
    public function load() : Persistable
    {
        if (!file_exists($this->path) || !is_readable($this->path)) {
            throw new RuntimeException('File ' . basename($path) . ' cannot be opened.');
        }

        $persistable = unserialize(file_get_contents($this->path));

        if ($persistable === false) {
            throw new RuntimeException('Object could not be reconstituted.');
        }

        return $persistable;
    }
}
