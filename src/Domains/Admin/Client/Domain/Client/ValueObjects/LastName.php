<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Domain\Client\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;

readonly class LastName extends StringValueObject
{
    public static function fromValue(?string $value): static
    {
        return new self($value);
    }
}