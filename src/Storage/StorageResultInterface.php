<?php

namespace Daikon\ReadModel\Storage;

use Daikon\Metadata\MetadataInterface;
use Daikon\ReadModel\Projection\ProjectionInterface;
use Daikon\ReadModel\Projection\ProjectionMapInterface;

interface StorageResultInterface extends \IteratorAggregate, \Countable
{
    public function getProjectionMap(): ProjectionMapInterface;

    public function getMetadata(): MetadataInterface;

    public function getFirst(): ?ProjectionInterface;

    public function isEmpty(): bool;
}
