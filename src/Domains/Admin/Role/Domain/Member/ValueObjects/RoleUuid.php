<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain\Member\ValueObjects;

use Project\Shared\Domain\ValueObject\UuidValueObject;

readonly class RoleUuid extends UuidValueObject
{
    public static function fromValue(?string $value): static
    {
        return new static($value);
    }
}