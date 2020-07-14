<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\ReadModel\Projection;

use Daikon\DataStructure\TypedMap;
use Daikon\Interop\ToNativeInterface;

final class ProjectionMap extends TypedMap implements ToNativeInterface
{
    public function __construct(iterable $projections = [])
    {
        $this->init($projections, [ProjectionInterface::class]);
    }

    public function toNative(): array
    {
        return $this->map(
            fn(string $key, ProjectionInterface $projection): array => $projection->toNative()
        )->unwrap();
    }
}
