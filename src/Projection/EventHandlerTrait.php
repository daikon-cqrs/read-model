<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Projection;

use Daikon\EventSourcing\Aggregate\Event\DomainEventInterface;
use Daikon\ReadModel\Exception\ReadModelException;

trait EventHandlerTrait
{
    public function applyEvent(DomainEventInterface $domainEvent): ProjectionInterface
    {
        return $this->invokeEventHandler($domainEvent);
    }

    private function invokeEventHandler(DomainEventInterface $event): ProjectionInterface
    {
        $handlerName = preg_replace('/Event$/', '', (new \ReflectionClass($event))->getShortName());
        $handlerMethod = 'when'.ucfirst($handlerName);
        $projection = clone $this;
        $handler = [$projection, $handlerMethod];
        if (!is_callable($handler)) {
            throw new ReadModelException("Handler '$handlerMethod' is not callable on ".self::class);
        }
        return call_user_func($handler, $event) ?? $projection;
    }
}
