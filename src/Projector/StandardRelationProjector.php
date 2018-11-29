<?php

namespace Daikon\ReadModel\Projector;

use Assert\Assertion;
use Daikon\MessageBus\EnvelopeInterface;
use Daikon\ReadModel\Repository\RepositoryInterface;

final class StandardRelationProjector implements ProjectorInterface
{
    /** @var RepositoryInterface */
    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(EnvelopeInterface $envelope): bool
    {
        //@TODO finish implementation
        return true;
    }
}
