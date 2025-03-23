<?php

declare(strict_types=1);

namespace Project\Domains\Institution\Authentication\Domain\Account\ValueObjects;

use Project\Shared\Domain\ValueObject\UuidValueObject;

readonly class Uuid extends UuidValueObject
{
    public static function fromValue(string $value): static
    {
        return new self($value);
    }
}