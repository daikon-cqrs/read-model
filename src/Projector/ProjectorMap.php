<?php

namespace Daikon\ReadModel\Projector;

use Daikon\DataStructure\TypedMapTrait;
use Daikon\EventSourcing\Aggregate\AggregateAlias;

final class ProjectorMap implements \IteratorAggregate, \Countable
{
    use TypedMapTrait;

    public function __construct(array $projectors = [])
    {
        $this->init($projectors, ProjectorInterface::class);
    }

    public function filterByAggregateAlias(AggregateAlias $aggregateAlias)
    {
        $alias = $aggregateAlias->toNative();
        return $this->compositeMap->filter(function ($key) use ($alias) {
            return strpos($key, $alias) === 0;
        });
    }
}
