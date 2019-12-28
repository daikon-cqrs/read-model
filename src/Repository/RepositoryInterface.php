<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\ReadModel\Repository;

use Daikon\ReadModel\Projection\ProjectionInterface;
use Daikon\ReadModel\Query\QueryInterface;
use Daikon\ReadModel\Storage\StorageResultInterface;

interface RepositoryInterface
{
    public function findById(string $identifier): StorageResultInterface;

    public function findByIds(array $identifiers): StorageResultInterface;

    public function search(QueryInterface $query, int $from = null, int $size = null): StorageResultInterface;

    public function persist(ProjectionInterface $projection): bool;

    public function makeProjection(): ProjectionInterface;
}
