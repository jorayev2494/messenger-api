<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Adapters\Role\DTOs;

use Project\Domains\Admin\Authentication\Infrastructure\Adapters\Role\Contracts\RoleApiInterface;
use Project\Domains\Admin\Authentication\Infrastructure\Adapters\Role\DTOs\VOs\Uuid;
use Project\Domains\Admin\Authentication\Infrastructure\Adapters\Role\DTOs\VOs\Value;

readonly class RoleAdapter
{
    public function __construct(
        private RoleApiInterface $api
    ) { }

    public function findRoleByUuid(Uuid $uuid): ?RoleDTO
    {
        $role = $this->api->findByUuid($uuid->value);

        if ($role === null) {
            return null;
        }

        /** @var string $uuid */
        [
            'uuid' => $uuid,
            'value' => $value,
        ] = $role;

        return RoleDTO::make(
            Uuid::fromValue($uuid),
            Value::fromValue($value)
        );
    }
}