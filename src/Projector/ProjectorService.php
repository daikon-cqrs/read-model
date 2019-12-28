<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\ReadModel\Projector;

use Assert\Assertion;
use Daikon\EventSourcing\EventStore\Commit\CommitInterface;
use Daikon\MessageBus\EnvelopeInterface;
use Daikon\MessageBus\MessageBusInterface;

final class ProjectorService implements ProjectorServiceInterface
{
    private const EVENTS_CHANNEL = 'events';

    /** @var EventProjectorMap */
    private $eventProjectorMap;

    /** @var MessageBusInterface */
    private $messageBus;

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
            foreach ($projectors->getIterator() as $projector) {
                $projector->handle($envelope);
            }
            $this->messageBus->publish($domainEvent, self::EVENTS_CHANNEL, $metadata);
        }
    }
}
