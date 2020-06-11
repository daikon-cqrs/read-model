<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Tests\ReadModel\Projector;

use Daikon\ReadModel\Projector\ProjectorInterface;
use Daikon\ReadModel\Projector\ProjectorMap;
use PHPUnit\Framework\TestCase;

final class ProjectorMapTest extends TestCase
{
    public function testConstructWithSelf(): void
    {
        $projectorMock = $this->createMock(ProjectorInterface::class);
        $projectorMap = new ProjectorMap(['mock' => $projectorMock]);
        $newMap = new ProjectorMap($projectorMap);
        $this->assertCount(1, $newMap);
        $this->assertNotSame($projectorMap, $newMap);
        $this->assertEquals($projectorMap, $newMap);
    }

    public function testPush(): void
    {
        $emptyMap = new ProjectorMap;
        $projectorMock = $this->createMock(ProjectorInterface::class);
        $projectorMap = $emptyMap->with('mock', $projectorMock);
        $this->assertCount(1, $projectorMap);
        $this->assertEquals($projectorMock, $projectorMap->get('mock'));
        $this->assertTrue($emptyMap->isEmpty());
    }
}
