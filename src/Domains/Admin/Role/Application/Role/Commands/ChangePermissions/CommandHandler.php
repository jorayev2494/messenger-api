<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Role\Commands\ChangePermissions;

use Project\Domains\Admin\Role\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Exceptions\DomainException;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private RoleRepositoryInterface $repository,
        private PermissionRepositoryInterface $permissionRepository
    ) { }

    public function __invoke(Command $command): void
    {
        $foundRole = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $foundRole ?? throw new DomainException('Role not found');

        $permissions = $this->permissionRepository->findManyByIds($command->permissionIds);

        $foundRole->clearPermissions();
        $permissions->forEach($foundRole->addPermission(...));

        $this->repository->save($foundRole);
    }
}