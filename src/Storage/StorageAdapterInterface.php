<?php

namespace Daikon\ReadModel\Storage;

use Daikon\ReadModel\Projection\ProjectionInterface;

interface StorageAdapterInterface
{
    public function read(string $identifier): ?ProjectionInterface;

    public function write(string $identifier, array $data): bool;

    public function delete(string $identifier): bool;
}
