<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\ReadModel\Projection;

use Daikon\EventSourcing\Aggregate\Event\DomainEventInterface;
use Daikon\Interop\FromNativeInterface;
use Daikon\Interop\ToNativeInterface;

interface ProjectionInterface extends FromNativeInterface, ToNativeInterface
{
    public function applyEvent(DomainEventInterface $domainEvent): self;
}
