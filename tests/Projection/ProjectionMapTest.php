<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Tests\ReadModel\Projection;

use Daikon\ReadModel\Projection\ProjectionInterface;
use Daikon\ReadModel\Projection\ProjectionMap;
use PHPUnit\Framework\TestCase;

final class ProjectionMapTest extends TestCase
{
    public function testConstructWithSelf(): void
    {
        $projectionMock = $this->createMock(ProjectionInterface::class);
        $projectionMap = new ProjectionMap(['mock' => $projectionMock]);
        $newMap = new ProjectionMap($projectionMap);
        $this->assertCount(1, $newMap);
        $this->assertNotSame($projectionMap, $newMap);
        $this->assertEquals($projectionMap, $newMap);
    }

    public function testPush(): void
    {
        $emptyMap = new ProjectionMap;
        $projectionMock = $this->createMock(ProjectionInterface::class);
        $projectionMap = $emptyMap->with('mock', $projectionMock);
        $this->assertCount(1, $projectionMap);
        $this->assertEquals($projectionMock, $projectionMap->get('mock'));
        $this->assertTrue($emptyMap->isEmpty());
    }

    public function testToNative(): void
    {
        $emptyMap = new ProjectionMap;
        $this->assertEquals([], $emptyMap->toNative());

        $projectionMock = $this->createMock(ProjectionInterface::class);
        $projectionMock->expects($this->once())->method('toNative')->willReturn(['key' => 'value']);
        $projectionMap = new ProjectionMap(['mock' => $projectionMock]);
        $this->assertEquals(['mock' => ['key' => 'value']], $projectionMap->toNative());
    }
}
