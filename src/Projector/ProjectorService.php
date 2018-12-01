<?php
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\ReadModel\Projector;

use Assert\Assertion;
use Daikon\EventSourcing\EventStore\Commit\CommitInterface;
use Daikon\MessageBus\EnvelopeInterface;
use Daikon\MessageBus\MessageBusInterface;
use Daikon\ReadModel\Exception\ReadModelException;

final class ProjectorService implements ProjectorServiceInterface
{
    /** @var EventProjectorMap */
    private $eventProjectorMap;

    /** @var MessageBusInterface */
    private $messageBus;

    public function __construct(EventProjectorMap $eventProjectorMap, MessageBusInterface $messageBus)
    {
        $this->eventProjectorMap = $eventProjectorMap;
        $this->messageBus = $messageBus;
    }

    public function handle(EnvelopeInterface $envelope): bool
    {
        /** @var CommitInterface $commit */
        $commit = $envelope->getMessage();
        Assertion::implementsInterface($commit, CommitInterface::class);

        $metadata = $envelope->getMetadata();
        foreach ($commit->getEventLog() as $domainEvent) {
            $projectors = $this->eventProjectorMap->findFor($domainEvent);
            foreach ($projectors->getIterator() as $projector) {
                if (!$projector->handle($envelope)) {
                    throw new ReadModelException(
                        sprintf('Projector %s failed to handle message.', get_class($projector))
                    );
                }
            }

            $this->messageBus->publish($domainEvent, 'events', $metadata);
        }

        return true;
    }
}
