<?php

namespace Daikon\ReadModel\Projector;

use Assert\Assertion;
use Daikon\EventSourcing\Aggregate\AggregatePrefix;
use Daikon\EventSourcing\EventStore\CommitInterface;
use Daikon\MessageBus\EnvelopeInterface;
use Daikon\ReadModel\Exception\ReadModelException;

final class ProjectorService implements ProjectorServiceInterface
{
    private $projectorMap;

    public function __construct(ProjectorMap $projectorMap)
    {
        $this->projectorMap = $projectorMap;
    }

    public function handle(EnvelopeInterface $envelope): bool
    {
        $commit = $envelope->getMessage();
        Assertion::implementsInterface($commit, CommitInterface::class);

        foreach ($commit->getEventLog() as $domainEvent) {
            $aggregatePrefix = AggregatePrefix::fromFqcn($domainEvent->getAggregateRootClass());
            $projectors = $this->projectorMap->filterByAggregatePrefix($aggregatePrefix);
            foreach ($projectors->getIterator() as $projector) {
                if (!$projector->handle($envelope)) {
                    throw new ReadModelException('Projector %s failed to handle message.');
                }
            }
        }

        return true;
    }
}
