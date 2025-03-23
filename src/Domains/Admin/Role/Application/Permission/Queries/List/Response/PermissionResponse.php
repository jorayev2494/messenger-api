<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Permission\Queries\List\Response;

use Project\Domains\Admin\Role\Domain\Permission\Permission;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'Admin:Role:Permission:CreateResponseScheme')]
readonly class PermissionResponse
{
    #[OA\Property(example: 5)]
    private int $id;

    #[OA\Property(example: 'Manager create')]
    private string $label;

    #[OA\Property(example: 'manager')]
    private string $resource;

    #[OA\Property(example: 'create')]
    private string $action;

    private function __construct(Permission $permission)
    {
        $this->id = $permission->getId()->value;
        $this->label = $permission->getLabel()->value;
        $this->resource = $permission->getResource()->value;
        $this->action = $permission->getAction()->value;
    }

    public static function make(Permission $permission): self
    {
        return new self($permission);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'resource' => $this->resource,
            'action' => $this->action,
        ];
    }
}