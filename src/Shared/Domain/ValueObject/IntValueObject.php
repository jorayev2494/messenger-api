<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

use Project\Shared\Domain\ValueObject\Contracts\ValueObject;

/**
 * @property-read int $value
 */
abstract readonly class IntValueObject extends ValueObject
{
    public static function fromValue(int $value): static
    {
        return new static($value);
    }
}