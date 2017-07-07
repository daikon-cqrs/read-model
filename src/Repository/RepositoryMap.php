<?php

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
