<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Client\Commands\Update;

use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\Email;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\FirstName;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\LastName;
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

        $foundByEmailClient = $this->repository->findByEmail(Email::fromValue($command->email));

        if ($foundByEmailClient !== null && $client->getUuid()->isNotEqual($foundByEmailClient->getUuid())) {
            throw new DomainException('The email already exists');
        }

        $client->changeEmail(Email::fromValue($command->email));
        $client->changeFirstName(FirstName::fromValue($command->firstName));
        $client->changeLastName(LastName::fromValue($command->lastName));

        $this->repository->save($client);
        $this->eventBus->publish(...$client->pullDomainEvents());
    }
}
