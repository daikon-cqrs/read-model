<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Projector;

use Daikon\EventSourcing\Aggregate\Event\DomainEventInterface;

interface EventProjectorInterface
{
    public function matches(DomainEventInterface $event): bool;

    public function getProjector(): ProjectorInterface;
}
