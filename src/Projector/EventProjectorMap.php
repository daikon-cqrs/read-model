<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\ReadModel\Projector;

use Daikon\DataStructure\TypedMap;
use Daikon\EventSourcing\Aggregate\Event\DomainEventInterface;

final class EventProjectorMap extends TypedMap
{
    public function __construct(iterable $eventProjectors = [])
    {
        $this->init($eventProjectors, [EventProjectorInterface::class]);
    }

    public function findFor(DomainEventInterface $event): ProjectorMap
    {
        $projectors = [];
        foreach ($this as $projectorKey => $eventProjector) {
            if ($eventProjector->matches($event)) {
                $projectors[$projectorKey] = $eventProjector->getProjector();
            }
        }
        return new ProjectorMap($projectors);
    }
}
