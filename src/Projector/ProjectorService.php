<?php

namespace Daikon\ReadModel\Projector;

use Assert\Assertion;
use Daikon\EventSourcing\EventStore\Commit\CommitInterface;
use Daikon\MessageBus\EnvelopeInterface;
use Daikon\MessageBus\MessageBusInterface;
use Daikon\ReadModel\Exception\ReadModelException;

final class ProjectorService implements ProjectorServiceInterface
{
    private $projectorMap;

    private $messageBus;

    public function __construct(ProjectorMap $projectorMap, MessageBusInterface $messageBus)
    {
        $this->projectorMap = $projectorMap;
        $this->messageBus = $messageBus;
    }

    public function handle(EnvelopeInterface $envelope): bool
    {
        $commit = $envelope->getMessage();
        Assertion::implementsInterface($commit, CommitInterface::class);

        $metadata = $envelope->getMetadata();
        foreach ($commit->getEventLog() as $domainEvent) {
            $fqcn = $domainEvent->getAggregateRootClass();
            $aggregateAlias = $fqcn::getAlias();
            $projectors = $this->projectorMap->filterByAggregateAlias($aggregateAlias);
            foreach ($projectors->getIterator() as $projector) {
                if (!$projector->handle($envelope)) {
                    throw new ReadModelException('Projector %s failed to handle message.');
                }
            }

            $metadata = $metadata->with('_aggregate_alias', $aggregateAlias->toNative());
            $this->messageBus->publish($domainEvent, 'events', $metadata);
        }

        return true;
    }
}
