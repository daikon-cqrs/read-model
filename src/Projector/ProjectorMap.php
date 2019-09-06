<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Projector;

use Daikon\DataStructure\TypedMapTrait;

final class ProjectorMap implements \IteratorAggregate, \Countable
{
    use TypedMapTrait;

    public function __construct(iterable $projectors = [])
    {
        $this->init($projectors, ProjectorInterface::class);
    }
}
