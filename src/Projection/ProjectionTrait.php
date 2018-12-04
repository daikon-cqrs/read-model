<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Projection;

use Daikon\EventSourcing\Aggregate\Event\DomainEventInterface;
use Daikon\ReadModel\Exception\ReadModelException;

trait ProjectionTrait
{
    use EventHandlerTrait;

    private $state;

    /** @param array $state */
    public static function fromNative($state): ProjectionInterface
    {
        return new static($state);
    }

    public function getAggregateId(): string
    {
        return $this->state['aggregateId'];
    }

    public function getAggregateRevision(): int
    {
        return $this->state['aggregateRevision'];
    }

    public function toNative(): array
    {
        return $this->state;
    }

    private function __construct(array $state = [])
    {
        $this->state = $state;
    }
}
