<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Member\Queries\GetRole\Response;

use Project\Domains\Admin\Role\Domain\Role\Role;
use Project\Shared\Contracts\ArrayableInterface;

readonly class Response implements ArrayableInterface
{
    private ?string $uuid;

    private ?string $value;

    private ?string $description;

    private function __construct(?Role $role)
    {
        $this->uuid = $role?->getUuid()->value;
        $this->value = $role?->getValue()->value;
        $this->description = $role?->getDescription()->value;
    }

    public static function make(?Role $role): self
    {
        return new self($role);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'value' => $this->value,
            'description' => $this->description,
        ];
    }
}