<?php

namespace Daikon\ReadModel\Projection;

use Daikon\DataStructure\TypedMapTrait;

final class ProjectionMap implements \IteratorAggregate, \Countable
{
    use TypedMapTrait;

    public function init(array $projections = [])
    {
        $this->init($projections, ProjectionInterface::class);
    }
}
