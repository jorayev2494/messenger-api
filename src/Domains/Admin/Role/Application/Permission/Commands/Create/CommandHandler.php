<?php

namespace Project\Domains\Admin\Role\Application\Permission\Commands\Create;

use Project\Domains\Admin\Role\Domain\Permission\Permission;
use Project\Domains\Admin\Role\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\Action;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\Label;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\Resource;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private PermissionRepositoryInterface $repository
    ) { }

    public function __invoke(Command $command): void
    {
        $permission = Permission::create(
            Label::fromValue($command->label),
            Resource::fromValue($command->resource),
            Action::fromValue($command->action),
        );

        $this->repository->save($permission);
    }
}