<?php

namespace Rubix\ML\Tests\Kernels\Distance;

use Rubix\ML\Kernels\Distance\CompressionDistance;
use Rubix\ML\Kernels\Distance\Distance;
use PHPUnit\Framework\TestCase;
use Generator;

/**
 * @group Distances
 * @covers \Rubix\ML\Kernels\Distance\CompressionDistance
 */
class CompressionDistanceTest extends TestCase
{
    /**
     * @var \Rubix\ML\Kernels\Distance\CompressionDistance
     */
    protected $kernel;

    /**
     * @before
     */
    protected function setUp() : void
    {
        $this->kernel = new CompressionDistance(3);
    }

    /**
     * @test
     */
    public function build() : void
    {
        $this->assertInstanceOf(CompressionDistance::class, $this->kernel);
        $this->assertInstanceOf(Distance::class, $this->kernel);
    }

    /**
     * @test
     * @dataProvider computeProvider
     *
     * @param list<string|int|float> $a
     * @param list<string|int|float> $b
     * @param float $expected
     */
    public function compute(array $a, array $b, $expected) : void
    {
        $distance = $this->kernel->compute($a, $b);

        $this->assertGreaterThanOrEqual(0.0, $distance);
        $this->assertEqualsWithDelta($expected, $distance, 1e-8);
    }

    /**
     * @return \Generator<array<mixed>>
     */
    public function computeProvider() : Generator
    {
        yield [
            ['soup', 'turkey', 'broccoli', 'cake'], ['salad', 'turkey', 'broccoli', 'pie'],
            0.11458333333333333,
        ];

        yield [
            ['salad', 'ham', 'peas', 'jello'], ['bread', 'steak', 'potato', 'cake'],
            0.32222222222222224,
        ];

        yield [
            ['toast', 'eggs', 'bacon'], ['toast', 'eggs', 'bacon'],
            0.0,
        ];
    }
}
