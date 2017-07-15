<?php

namespace Daikon\ReadModel\Projector;

use Assert\Assertion;
use Daikon\MessageBus\EnvelopeInterface;
use Daikon\EventSourcing\Aggregate\DomainEventInterface;

final class RelationProjectorService implements ProjectorServiceInterface
{
    private $projectorMap;

    public function __construct(ProjectorMap $projectorMap)
    {
        $this->projectorMap = $projectorMap;
    }

    public function handle(EnvelopeInterface $envelope): bool
    {
        $domainEvent = $envelope->getMessage();
        Assertion::implementsInterface($domainEvent, DomainEventInterface::class);

        //@todo load projection, apply event and persist
        var_dump($domainEvent);

        return true;
    }
}
