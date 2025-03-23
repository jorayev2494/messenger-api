<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Role\Commands\Create;

use Project\Domains\Admin\Role\Domain\Role\Role;
use Project\Domains\Admin\Role\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\Description;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\IsSuperAdmin;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\Uuid;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\Value;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Exceptions\DomainException;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private RoleRepositoryInterface $repository
    ) { }

    public function __invoke(Command $command): void
    {
        if ($command->isSuperAdmin) {
            $foundSuperAdmin = $this->repository->findSuperAdmin();

            if ($foundSuperAdmin !== null) {
                throw new DomainException('Super admin already exists');
            }
        }

        $role = Role::create(
            Uuid::fromValue($command->uuid),
            Value::fromValue($command->value),
            Description::fromValue($command->description)
        );

        $role->setIsSuperAdmin(IsSuperAdmin::fromValue($command->isSuperAdmin));

        $this->repository->save($role);
    }
}