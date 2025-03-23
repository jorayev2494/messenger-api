<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Role\Queries\Show\Response;

use Project\Domains\Admin\Role\Domain\Permission\Permission;
use Project\Domains\Admin\Role\Domain\Role\Role;
use Project\Shared\Utils\Response\Contracts\HttpResponseInterface;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'Admin:Role:ShowResponseSchema')]
readonly class RoleResponse implements HttpResponseInterface
{
    #[OA\Property(example: 'aabe3af0-4348-4492-bbae-ac4e40c83ef8', uniqueItems: true)]
    protected string $uuid;

    #[OA\Property(example: 'Admin')]
    protected string $value;

    #[OA\Property(example: 'Admin description')]
    protected ?string $description;

    // #[OA\Property(example: 'Admin description')]
    protected array $permissions;

    #[OA\Property(property: 'is_super_admin', example: true, enum: [true, false])]
    private bool $isSuperAdmin;

    private function __construct(
        private Role $role
    ) { }

    public static function make(Role $role): self
    {
        return new self($role);
    }

    public function toHttpResponse(): array
    {
        return [
            'uuid' => $this->role->getUuid()->value,
            'value' => $this->role->getValue()->value,
            'description' => $this->role->getDescription()->value,
            'is_super_admin' => $this->role->getIsSuperAdmin()->value,
            'permissions' => $this->role->getPermissions()->map(static fn (Permission $permission): array => [
                'id' => $permission->getId()->value,
                'label' => $permission->getLabel()->value,
                'action' => $permission->getAction()->value,
                'resource' => $permission->getResource()->value,
            ])->toArray(),
        ];
    }
}