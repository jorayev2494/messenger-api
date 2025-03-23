<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Role\Queries\Index\Response;

use Project\Domains\Admin\Role\Domain\Role\Role;
use Project\Shared\Contracts\ArrayableInterface;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'Admin:Role:IndexResponseScheme')]
readonly class RoleResponse implements ArrayableInterface
{
    #[OA\Property(example: 'aabe3af0-4348-4492-bbae-ac4e40c83ef8', uniqueItems: true)]
    private string $uuid;

    #[OA\Property(example: 'Admin')]
    private string $value;

    #[OA\Property(example: 'Admin description')]
    private ?string $description;

    #[OA\Property(property: 'is_super_admin', example: true, enum: [true, false])]
    private bool $isSuperAdmin;

    private function __construct(Role $role) {
        $this->uuid = $role->getUuid()->value;
        $this->value = $role->getValue()->value;
        $this->description = $role->getDescription()->value;
        $this->isSuperAdmin = $role->getIsSuperAdmin()->value;
    }

    public static function make(Role $role): self
    {
        return new self($role);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'value' => $this->value,
            'description' => $this->description,
            'is_super_admin' => $this->isSuperAdmin,
        ];
    }
}