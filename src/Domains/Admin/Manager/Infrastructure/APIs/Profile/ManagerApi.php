<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\APIs\Profile;

use Project\Domains\Admin\Manager\Application\Manager\Commands\Update\Command;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\Contracts\ManagerApiInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

readonly class ManagerApi implements ManagerApiInterface
{
    public function __construct(
        private ManagerRepositoryInterface $repository
    ) { }

    public function findByUuid(string $uuid): ?array
    {
        $manager = $this->repository->findByUuid(Uuid::fromValue($uuid));

        if ($manager === null) {
            return null;
        }

        return [
            'uuid' => $manager->getUuid()->value,
            'email' => $manager->getEmail()->value,
            'first_name' => $manager->getFirstName()->value,
            'last_name' => $manager->getLastName()->value,
        ];
    }

    public function update(string $uuid, string $email, string $firstName, string $lastName): void
    {
        resolve(CommandBusInterface::class)->dispatch(new Command($uuid, $email, $firstName, $lastName));
    }
}