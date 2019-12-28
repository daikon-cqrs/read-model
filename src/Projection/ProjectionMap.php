<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\ReadModel\Projection;

use Daikon\DataStructure\TypedMapTrait;

final class ProjectionMap implements ProjectionMapInterface
{
    use TypedMapTrait;

    public function __construct(iterable $projections = [])
    {
        $this->init($projections, ProjectionInterface::class);
    }
}
