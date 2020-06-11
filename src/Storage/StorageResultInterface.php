<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\ReadModel\Storage;

use Countable;
use Daikon\Metadata\MetadataInterface;
use Daikon\ReadModel\Projection\ProjectionInterface;
use Daikon\ReadModel\Projection\ProjectionMap;
use IteratorAggregate;

interface StorageResultInterface extends IteratorAggregate, Countable
{
    public function getProjectionMap(): ProjectionMap;

    public function getMetadata(): MetadataInterface;

    public function getFirst(): ?ProjectionInterface;

    public function getLast(): ?ProjectionInterface;

    public function isEmpty(): bool;
}
