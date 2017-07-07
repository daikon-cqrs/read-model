<?php

namespace Daikon\ReadModel\Projection;

use Daikon\EventSourcing\Aggregate\DomainEventInterface;

interface ProjectionInterface
{
    public function getAggregateId(): string;

    public function getAggregateRevision(): int;

    public function applyEvent(DomainEventInterface $domainEvent): ProjectionInterface;

    public function toArray(): array;
}
