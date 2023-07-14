<?php

namespace Rubix\ML\Kernels\Distance;

use Rubix\ML\DataType;
use Rubix\ML\Exceptions\InvalidArgumentException;

use function gzdeflate;

/**
 * Compression Distance
 *
 * References:
 * [1] Z. Jiang. (2023). “Low-Resource” Text Classification: A Parameter-Free Classification Method
 * with Compressors.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class CompressionDistance implements Distance
{
    /**
     * The compression level between 0 and 9, 0 meaning no compression.
     *
     * @var int
     */
    protected int $level;

    /**
     * @param int $level
     * @throws \Rubix\ML\Exceptions\InvalidArgumentException
     */
    public function __construct(int $level = 3)
    {
        if ($level < 0 or $level > 9) {
            throw new InvalidArgumentException('Level must be'
                . " between 0 and 9, $level given.");
        }

        $this->level = $level;
    }

    /**
     * Return the data types that this kernel is compatible with.
     *
     * @return \Rubix\ML\DataType[]
     */
    public function compatibility() : array
    {
        return [
            DataType::categorical(),
        ];
    }

    /**
     * Return the level of compression between 0 and 9.
     *
     * @internal
     *
     * @return int
     */
    public function level() : int
    {
        return $this->level;
    }

    /**
     * Compute the distance between two vectors.
     *
     * @param list<string|int|float> $a
     * @param list<string|int|float> $b
     * @return float
     */
    public function compute(array $a, array $b) : float
    {
        $distance = 0.0;

        foreach ($a as $i => $valueA) {
            $valueB = $b[$i];
    
            $sizeAA = strlen(gzdeflate($valueA . $valueA, $this->level));
            $sizeBB = strlen(gzdeflate($valueB . $valueB, $this->level));
            $sizeAB = strlen(gzdeflate($valueA . $valueB, $this->level));
    
            $min = min($sizeAA, $sizeBB);
            $max = max($sizeAA, $sizeBB);
    
            $distance += ($sizeAB - $min) / $max;
        }

        return $distance / count($a);
    }

    /**
     * Return the string representation of the object.
     *
     * @return string
     */
    public function __toString() : string
    {
        return "Deflate (level: {$this->level})";
    }
}
