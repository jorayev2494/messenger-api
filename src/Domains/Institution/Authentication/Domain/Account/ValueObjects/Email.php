<?php

declare(strict_types=1);

namespace Project\Domains\Institution\Authentication\Domain\Account\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;

readonly class Email extends StringValueObject
{
    public string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromValue(string $value): static
    {
        return new self($value);
    }
}