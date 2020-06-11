<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\ReadModel\Projector;

use Daikon\EventSourcing\EventStore\Commit\CommitInterface;
use Daikon\Interop\Assertion;
use Daikon\MessageBus\EnvelopeInterface;
use Daikon\MessageBus\MessageBusInterface;

final class ProjectorService implements ProjectorServiceInterface
{
    private const EVENTS_CHANNEL = 'events';

    private EventProjectorMap $eventProjectorMap;

    private MessageBusInterface $messageBus;

    public function __construct(EventProjectorMap $eventProjectorMap, MessageBusInterface $messageBus)
    {
        $this->eventProjectorMap = $eventProjectorMap;
        $this->messageBus = $messageBus;
    }

    public function handle(EnvelopeInterface $envelope): void
    {
        /** @var CommitInterface $commit */
        $commit = $envelope->getMessage();
        Assertion::implementsInterface($commit, CommitInterface::class);

        $metadata = $envelope->getMetadata();
        foreach ($commit->getEventLog() as $domainEvent) {
            $projectors = $this->eventProjectorMap->findFor($domainEvent);
            $projectors->map(fn(string $key, ProjectorInterface $projector) => $projector->handle($envelope));
            $this->messageBus->publish($domainEvent, self::EVENTS_CHANNEL, $metadata);
        }
    }
}
