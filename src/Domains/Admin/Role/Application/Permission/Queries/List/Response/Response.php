<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Permission\Queries\List\Response;

use Project\Domains\Admin\Role\Domain\Permission\Permission;
use Project\Shared\Contracts\ArrayableInterface;

readonly class Response implements ArrayableInterface
{
    private function __construct(
        private array $permissions
    ) { }

    public static function make(array $permission): self
    {
        return new self($permission);
    }

    public function toArray(): array
    {
        return array_map(
            static fn (Permission $permission): array => PermissionResponse::make($permission)->toArray(),
            $this->permissions
        );
    }
}