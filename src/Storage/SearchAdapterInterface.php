<?php

namespace Daikon\ReadModel\Storage;

use Daikon\ReadModel\Projection\ProjectionMap;
use Daikon\ReadModel\Query\QueryInterface;

interface SearchAdapterInterface
{
    public function search(QueryInterface $query, $from, $size): ProjectionMap;
}