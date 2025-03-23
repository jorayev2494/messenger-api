<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

use Project\Shared\Domain\ValueObject\Contracts\ValueObject;

/**
 * @property-read boolean $value
 */
abstract readonly class BooleanValueObject extends ValueObject
{
    public static function fromValue(bool $value): static
    {
        return new static($value);
    }
}