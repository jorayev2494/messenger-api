<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Commands\Create;

use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\FirstName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\LastName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\Exceptions\DomainException;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ManagerRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) { }

    public function __invoke(Command $command): void
    {
        $foundManager = $this->repository->findByEmail(Email::fromValue($command->email));

        if ($foundManager !== null) {
            throw new DomainException('The email already exists');
        }

        $manager = Manager::create(
            Uuid::fromValue($command->uuid),
            Email::fromValue($command->email),
            FirstName::fromValue($command->firstName),
            LastName::fromValue($command->lastName)
        );

        $this->repository->save($manager);
        $this->eventBus->publish(...$manager->pullDomainEvents());
    }
}