<?php

namespace Project\Domains\Admin\Authentication\Infrastructure\Adapters\Role\Contracts;

interface RoleApiInterface
{
    public function findByUuid(string $uuid): ?array;
}