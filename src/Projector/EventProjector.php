<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Projector;

use Daikon\EventSourcing\Aggregate\Event\DomainEventInterface;

final class EventProjector implements EventProjectorInterface
{
    private $eventExpressions;

    private $projector;

    public function __construct(array $eventExpressions, ProjectorInterface $projector)
    {
        $this->eventExpressions = $eventExpressions;
        $this->projector = $projector;
    }

    public function matches(DomainEventInterface $event): bool
    {
        $eventFqcn = get_class($event);
        foreach ($this->eventExpressions as $eventExpression) {
            // @todo implement
        }
        return true;
    }

    public function getProjector(): ProjectorInterface
    {
        return $this->projector;
    }

    public function getEventExpressions(): array
    {
        return $this->eventExpressions;
    }
}
