<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Projector;

use Assert\Assertion;
use Daikon\EventSourcing\EventStore\Commit\CommitInterface;
use Daikon\MessageBus\EnvelopeInterface;
use Daikon\ReadModel\Projection\ProjectionInterface;
use Daikon\ReadModel\Repository\RepositoryInterface;

final class StandardProjector implements ProjectorInterface
{
    /** @var RepositoryInterface */
    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(EnvelopeInterface $envelope): void
    {
        /** @var CommitInterface $commit */
        $commit = $envelope->getMessage();
        Assertion::implementsInterface($commit, CommitInterface::class);

        if ($commit->getStreamRevision()->isInitial()) {
            $projection = $this->repository->makeProjection();
        } else {
            $aggregateId = (string)$commit->getStreamId();
            $projection = $this->repository->findById($aggregateId);
        }

        Assertion::isInstanceOf($projection, ProjectionInterface::class);

        foreach ($commit->getEventLog() as $domainEvent) {
            /** @psalm-suppress PossiblyNullReference */
            $projection = $projection->applyEvent($domainEvent);
        }

        /** @psalm-suppress PossiblyNullArgument */
        $this->repository->persist($projection);
    }
}
