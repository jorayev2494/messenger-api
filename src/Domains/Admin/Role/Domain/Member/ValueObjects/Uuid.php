<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain\Member\ValueObjects;

use Project\Shared\Domain\ValueObject\UuidValueObject;

readonly class Uuid extends UuidValueObject
{
    protected function __construct(?string $value)
    {
        parent::__construct($value);
    }

    public static function fromValue(?string $value): static
    {
        return new static($value);
    }
}