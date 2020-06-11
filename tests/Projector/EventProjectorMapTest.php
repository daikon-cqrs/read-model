<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Tests\ReadModel\Projector;

use Daikon\EventSourcing\Aggregate\Event\DomainEventInterface;
use Daikon\ReadModel\Projector\EventProjector;
use Daikon\ReadModel\Projector\EventProjectorInterface;
use Daikon\ReadModel\Projector\EventProjectorMap;
use Daikon\ReadModel\Projector\ProjectorInterface;
use PHPUnit\Framework\TestCase;

final class EventProjectorMapTest extends TestCase
{
    public function testConstructWithSelf(): void
    {
        $eventProjectorMock = $this->createMock(EventProjectorInterface::class);
        $eventProjectorMap = new EventProjectorMap(['mock' => $eventProjectorMock]);
        $newMap = new EventProjectorMap($eventProjectorMap);
        $this->assertCount(1, $newMap);
        $this->assertNotSame($eventProjectorMap, $newMap);
        $this->assertEquals($eventProjectorMap, $newMap);
    }

    public function testPush(): void
    {
        $emptyMap = new EventProjectorMap;
        $eventProjectorMock = $this->createMock(EventProjectorInterface::class);
        $eventProjectorMap = $emptyMap->with('mock', $eventProjectorMock);
        $this->assertCount(1, $eventProjectorMap);
        $this->assertEquals($eventProjectorMock, $eventProjectorMap->get('mock'));
        $this->assertTrue($emptyMap->isEmpty());
    }

    public function testFindFor(): void
    {
        $emptyMap = new EventProjectorMap;
        $domainEventMock = $this->createMock(DomainEventInterface::class);
        $projectorMap = $emptyMap->findFor($domainEventMock);
        $this->assertCount(0, $projectorMap);

        $mockProjector = $this->createMock(ProjectorInterface::class);
        $mockEventProjector = new EventProjector([get_class($domainEventMock)], $mockProjector);
        $eventProjectorMap = new EventProjectorMap(['mock' => $mockEventProjector]);
        $projectorMap = $eventProjectorMap->findFor($domainEventMock);
        $this->assertCount(1, $projectorMap);
        $this->assertNotSame($mockProjector, $projectorMap->first());
        $this->assertEquals($mockProjector, $projectorMap->first());
    }
}
