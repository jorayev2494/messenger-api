<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;

readonly class LastName extends StringValueObject
{
    public static function fromValue(?string $value): static
    {
        return new self($value);
    }
}