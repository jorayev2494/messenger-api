<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\APIs\Authentication;

use Project\Domains\Admin\Authentication\Infrastructure\Adapters\Role\Contracts\RoleApiInterface;
use Project\Domains\Admin\Role\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\Uuid;

readonly class RoleApi implements RoleApiInterface
{
    public function __construct(
        private RoleRepositoryInterface $repository
    ) { }

    public function findByUuid(string $uuid): ?array
    {
        $foundRole = $this->repository->findByUuid(Uuid::fromValue($uuid));

        if ($foundRole === null) {
            return null;
        }

        return [
            'uuid' => $foundRole->getUuid()->value,
            'value' => $foundRole->getValue()->value,
            'permissions' => $foundRole->getPermissions()->toArray(),
        ];
    }
}