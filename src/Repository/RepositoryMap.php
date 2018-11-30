<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Repository;

use Daikon\DataStructure\TypedMapTrait;

final class RepositoryMap implements \IteratorAggregate, \Countable
{
    use TypedMapTrait;

    public function __construct(array $repositories = [])
    {
        $this->init($repositories, RepositoryInterface::class);
    }
}
