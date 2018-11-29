<?php

namespace Daikon\ReadModel\Projection;

use Daikon\EventSourcing\Aggregate\Event\DomainEventInterface;
use Daikon\Interop\FromNativeInterface;
use Daikon\Interop\ToNativeInterface;

interface ProjectionInterface extends FromNativeInterface, ToNativeInterface
{
    public function getAggregateId(): string;

    public function getAggregateRevision(): int;

    public function applyEvent(DomainEventInterface $domainEvent): ProjectionInterface;
}
