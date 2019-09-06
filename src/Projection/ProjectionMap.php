<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Projection;

use Daikon\DataStructure\TypedMapTrait;

final class ProjectionMap implements ProjectionMapInterface
{
    use TypedMapTrait;

    /** @param array $projections */
    public static function fromNative($projections): self
    {
        return new self($projections);
    }

    private function __construct(array $projections = [])
    {
        $this->init($projections, ProjectionInterface::class);
    }
}
