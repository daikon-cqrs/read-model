<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\ReadModel\Repository;

use Daikon\DataStructure\TypedMap;

final class RepositoryMap extends TypedMap
{
    public function __construct(iterable $repositories = [])
    {
        $this->init($repositories, [RepositoryInterface::class]);
    }
}
