<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain\Permission;

interface PermissionRepositoryInterface
{
    public function list(): array;

    public function findManyByIds(array $permissionIds): PermissionCollection;

    public function save(Permission $permission): void;
}
