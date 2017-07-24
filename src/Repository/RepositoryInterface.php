<?php

namespace Daikon\ReadModel\Repository;

use Daikon\ReadModel\Projection\ProjectionInterface;
use Daikon\ReadModel\Projection\ProjectionMap;
use Daikon\ReadModel\Query\QueryInterface;

interface RepositoryInterface
{
    public function findById(string $identifier): ProjectionInterface;

    public function findByIds(array $identifiers): ProjectionMap;

    public function search(QueryInterface $query, int $from = null, int $size = null): ProjectionMap;

    public function persist(ProjectionInterface $projection): bool;

    public function makeProjection(): ProjectionInterface;
}
