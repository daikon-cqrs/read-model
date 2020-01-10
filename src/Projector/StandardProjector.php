<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\ReadModel\Projector;

use Assert\Assertion;
use Daikon\EventSourcing\Aggregate\Event\DomainEventInterface;
use Daikon\EventSourcing\EventStore\Commit\CommitInterface;
use Daikon\MessageBus\EnvelopeInterface;
use Daikon\ReadModel\Projection\ProjectionInterface;
use Daikon\ReadModel\Repository\RepositoryInterface;

final class StandardProjector implements ProjectorInterface
{
    private RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(EnvelopeInterface $envelope): void
    {
        /** @var CommitInterface $commit */
        $commit = $envelope->getMessage();
        Assertion::implementsInterface($commit, CommitInterface::class);

        if ($commit->getSequence()->isInitial()) {
            /** @var ProjectionInterface $projection */
            $projection = $this->repository->makeProjection();
        } else {
            $aggregateId = (string)$commit->getAggregateId();
            /** @var ProjectionInterface $projection */
            $projection = $this->repository->findById($aggregateId)->getFirst();
        }

        Assertion::isInstanceOf($projection, ProjectionInterface::class);

        /** @var DomainEventInterface $domainEvent */
        foreach ($commit->getEventLog() as $domainEvent) {
            $projection = $projection->applyEvent($domainEvent);
        }

        $this->repository->persist($projection);
    }
}
