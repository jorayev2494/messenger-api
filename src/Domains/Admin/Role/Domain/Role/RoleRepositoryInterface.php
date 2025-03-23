<?php

namespace Project\Domains\Admin\Role\Domain\Role;

use Project\Domains\Admin\Role\Domain\Role\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate\Paginator;

interface RoleRepositoryInterface
{
    public function paginate(): Paginator;

    public function findByUuid(Uuid $uuid): ?Role;

    public function findSuperAdmin(): ?Role;

    public function save(Role $role): void;

    public function delete(Role $role): void;
}