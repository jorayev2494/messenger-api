<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Adapters\Role\DTOs;

use Project\Domains\Admin\Authentication\Infrastructure\Adapters\Role\DTOs\VOs\Uuid;
use Project\Domains\Admin\Authentication\Infrastructure\Adapters\Role\DTOs\VOs\Value;

readonly class RoleDTO
{
    private function __construct(
        public Uuid $uuid,
        public Value $value
    ) { }

    public static function make(Uuid $uuid, Value $value): self
    {
        return new self($uuid, $value);
    }
}