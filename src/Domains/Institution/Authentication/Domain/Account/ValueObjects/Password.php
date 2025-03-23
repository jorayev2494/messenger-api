<?php

declare(strict_types=1);

namespace Project\Domains\Institution\Authentication\Domain\Account\ValueObjects;

use Project\Infrastructure\Services\Authentication\ValueObjects\PasswordValueObject;

readonly class Password extends PasswordValueObject
{
    private function __construct(public string $value)
    { }

    public static function fromValue(string $value): static
    {
        return new self($value);
    }
}