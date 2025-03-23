<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authentication\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;

readonly class PasswordValueObject extends StringValueObject
{
    public const LENGTH = 8;

    public function hash(): string
    {
        return bcrypt($this->value);
    }
}