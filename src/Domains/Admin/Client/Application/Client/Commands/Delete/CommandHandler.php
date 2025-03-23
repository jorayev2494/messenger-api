<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Client\Commands\Delete;

use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\Exceptions\DomainException;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ClientRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) { }

    public function __invoke(Command $command): void
    {
        $client = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $client ?? throw new DomainException('Client not found');

        $client->delete();
        $this->repository->delete($client);
        $this->eventBus->publish(...$client->pullDomainEvents());
    }
}
