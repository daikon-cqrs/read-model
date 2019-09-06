<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Storage;

interface StorageAdapterInterface
{
    public function read(string $identifier): StorageResultInterface;

    public function write(string $identifier, array $data): bool;

    public function delete(string $identifier): bool;
}
