<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

use Project\Shared\Domain\ValueObject\Contracts\ValueObject;

/**
 * @property-read string $value
 */
abstract readonly class StringValueObject extends ValueObject
{
    public static function fromValue(string $value): static
    {
        return new static($value);
    }
}