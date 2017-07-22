<?php

namespace Daikon\ReadModel\Repository;

use Daikon\ReadModel\Projection\ProjectionInterface;
use Daikon\ReadModel\Projection\ProjectionMap;

interface RepositoryInterface
{
    public function findById(string $identifier): ProjectionInterface;

    public function findByIds(array $identifiers): ProjectionMap;

    public function search($query, $from, $size): ProjectionMap;

    public function persist(ProjectionInterface $projection): bool;

    public function makeProjection(): ProjectionInterface;
}
