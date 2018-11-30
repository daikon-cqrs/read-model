<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Projector;

use Daikon\DataStructure\TypedMapTrait;
use Daikon\EventSourcing\Aggregate\Event\DomainEventInterface;

final class EventProjectorMap implements \IteratorAggregate, \Countable
{
    use TypedMapTrait;

    public function __construct(array $eventProjectors = [])
    {
        $this->init($eventProjectors, EventProjectorInterface::class);
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
