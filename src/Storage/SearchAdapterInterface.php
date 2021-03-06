<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\ReadModel\Storage;

use Daikon\ReadModel\Query\QueryInterface;

interface SearchAdapterInterface
{
    public function search(QueryInterface $query, int $from = null, int $size = null): StorageResultInterface;
}
