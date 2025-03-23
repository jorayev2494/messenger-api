<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain\Permission\ValueObjects;

use Project\Shared\Domain\ValueObject\IntValueObject;

readonly class Id extends IntValueObject implements \Stringable
{
    public function __toString(): string
    {
        return (string) $this->value;
    }
}