<?php

namespace Rubix\ML\Extractors;

use InvalidArgumentException;
use RuntimeException;
use IteratorAggregate;
use ArrayIterator;

use function is_null;

/**
 * JSON
 *
 * Javascript Object Notation is a standardized lightweight plain-text representation that
 * is widely used. JSON has the advantage of retaining type information, however since the
 * entire JSON blob is read on load, it is not cursorable like CSV or NDJSON.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 *
 * @implements IteratorAggregate<int, array>
 */
class JSON implements IteratorAggregate
{
    /**
     * The path to the JSON file.
     *
     * @var string
     */
    protected $path;

    /**
     * @param string $path
     * @throws \InvalidArgumentException
     */
    public function __construct(string $path)
    {
        if (!is_file($path)) {
            throw new InvalidArgumentException("Path $path does not exist.");
        }
        
        if (!is_readable($path)) {
            throw new InvalidArgumentException("Path $path is not readable.");
        }

        $this->path = $path;
    }

    /**
     * Return an iterator for the records in the data table.
     *
     * @throws \RuntimeException
     * @return \ArrayIterator<int, array>
     */
    public function getIterator() : ArrayIterator
    {
        $data = file_get_contents($this->path);

        if (!$data) {
            throw new RuntimeException("Could not open $this->path.");
        }

        $records = json_decode($data, true);

        if (is_null($records)) {
            throw new RuntimeException('Malformed JSON document.');
        }

        return new ArrayIterator($records);
    }
}
