<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Commands\Update;

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
        $manager = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $manager ?? throw new DomainException('Manager not found');

        $foundByEmailManager = $this->repository->findByEmail(Email::fromValue($command->email));

        if ($foundByEmailManager !== null && $manager->getUuid()->isNotEqual($foundByEmailManager->getUuid())) {
            throw new DomainException('The email already exists');
        }

        $manager->changeEmail(Email::fromValue($command->email));
        $manager->changeFirstName(FirstName::fromValue($command->firstName));
        $manager->changeLastName(LastName::fromValue($command->lastName));

        $this->repository->save($manager);
        $this->eventBus->publish(...$manager->pullDomainEvents());
    }
}
