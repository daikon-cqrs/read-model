<?php

namespace Daikon\ReadModel\Projector;

use Assert\Assertion;
use Daikon\MessageBus\EnvelopeInterface;
use Daikon\EventSourcing\Aggregate\Event\DomainEventInterface;

final class RelationProjectorService implements ProjectorServiceInterface
{
    /** @var ProjectorMap */
    private $projectorMap;

    public function __construct(ProjectorMap $projectorMap)
    {
        $this->projectorMap = $projectorMap;
    }

    public function handle(EnvelopeInterface $envelope): bool
    {
        /** @var DomainEventInterface $domainEvent */
        $domainEvent = $envelope->getMessage();
        Assertion::implementsInterface($domainEvent, DomainEventInterface::class);

        $fqcn = $domainEvent->getAggregateRootClass();
        $aggregateAlias = $fqcn::getAlias();
        $aggregateId = $domainEvent->getAggregateId();

        //@todo load projections, apply event and persist

        return true;
    }
}
