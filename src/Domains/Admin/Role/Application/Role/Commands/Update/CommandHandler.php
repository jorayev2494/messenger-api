<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Role\Commands\Update;

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
        $foundRole = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $foundRole ?? throw new DomainException('Role not found');

        if ($command->isSuperAdmin) {
            $foundSuperAdmin = $this->repository->findSuperAdmin();
            if ($foundSuperAdmin?->getUuid()->isNotEqual($foundRole->getUuid())) {
                throw new DomainException('Super admin already exists');
            }
        }

        $foundRole->setValue(Value::fromValue($command->value));
        $foundRole->setDescription(Description::fromValue($command->description));
        $foundRole->setIsSuperAdmin(IsSuperAdmin::fromValue($command->isSuperAdmin));

        $this->repository->save($foundRole);
    }
}