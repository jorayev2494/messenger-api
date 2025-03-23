<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Role\Queries\Show\Response;

use Project\Domains\Admin\Role\Domain\Permission\Permission;
use Project\Domains\Admin\Role\Domain\Role\Role;
use Project\Shared\Utils\Response\Contracts\HttpResponseInterface;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'Admin:Role:ShowRolePermissionResponseSchema')]
readonly class PermissionResponse implements HttpResponseInterface
{
    #[OA\Property(example: 6, uniqueItems: true)]
    protected int $id;

    #[OA\Property(example: 'Admin')]
    protected string $label;

    #[OA\Property(example: 'Admin resource')]
    protected ?string $resource;

    #[OA\Property(example: 'Admin action')]
    protected ?string $action;

    // #[OA\Property(example: 'Admin description')]
    protected array $permissions;

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
            'permissions' => $this->role->getPermissions()->map(static fn (Permission $permission): array => [
                'id' => $permission->getId()->value,
                'label' => $permission->getLabel()->value,
                'action' => $permission->getAction()->value,
                'resource' => $permission->getResource()->value,
            ])->toArray(),
        ];
    }
}