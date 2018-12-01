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
use Daikon\ReadModel\Repository\RepositoryInterface;

final class StandardProjector implements ProjectorInterface
{
    /** @var RepositoryInterface */
    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(EnvelopeInterface $envelope): bool
    {
        /** @var CommitInterface $commit */
        $commit = $envelope->getMessage();
        Assertion::isInstanceOf($commit, CommitInterface::class);

        if ($commit->getStreamRevision()->toNative() === 1) {
            $projection = $this->repository->makeProjection();
        } else {
            $aggregateId = $commit->getStreamId()->toNative();
            $projection = $this->repository->findById($aggregateId);
        }

        foreach ($commit->getEventLog() as $domainEvent) {
            $projection = $projection->applyEvent($domainEvent);
        }

        return $this->repository->persist($projection);
    }
}
