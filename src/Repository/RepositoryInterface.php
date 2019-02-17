<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Repository;

use Daikon\ReadModel\Projection\ProjectionInterface;
use Daikon\ReadModel\Projection\ProjectionMap;
use Daikon\ReadModel\Query\QueryInterface;

interface RepositoryInterface
{
    public function findById(string $identifier): ?ProjectionInterface;

    public function findByIds(array $identifiers): ProjectionMap;

    public function search(QueryInterface $query, int $from = null, int $size = null): ProjectionMap;

    public function persist(ProjectionInterface $projection): bool;

    public function makeProjection(): ProjectionInterface;
}
