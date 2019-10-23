<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Storage;

use Daikon\ReadModel\Query\QueryInterface;

interface ScrollAdapterInterface
{
    /** @param null|mixed $cursor */
    public function scrollStart(QueryInterface $query, int $size = null, $cursor = null): StorageResultInterface;

    /** @param mixed $cursor */
    public function scrollNext($cursor, int $size = null): StorageResultInterface;

    /** @param mixed $cursor */
    public function scrollEnd($cursor): void;
}
