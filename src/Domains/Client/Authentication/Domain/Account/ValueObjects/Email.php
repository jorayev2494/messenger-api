<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Account\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;

readonly class Email extends StringValueObject
{
    public static function fromValue(string $value): static
    {
        return new self($value);
    }
}