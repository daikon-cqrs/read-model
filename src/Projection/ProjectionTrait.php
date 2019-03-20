<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Projection;

use Daikon\Entity\Entity\EntityInterface;

trait ProjectionTrait
{
    use EventHandlerTrait;

    /** @var EntityInterface */
    private $properties;

    public function toNative(): array
    {
        $data = $this->properties ? $this->properties->toNative() : [];
        $data[EntityInterface::TYPE_KEY] = static::class;
        return $data;
    }

    private function __construct(EntityInterface $properties)
    {
        $this->properties = $properties;
    }
}
