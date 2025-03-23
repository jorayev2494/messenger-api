<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject\Contracts;

use Project\Shared\Contracts\EqualableInterface;
use Project\Shared\Contracts\NullableInterface;
use Project\Shared\Domain\Exceptions\DomainException;

readonly abstract class ValueObject implements EqualableInterface, NullableInterface
{
    public mixed $value;

    protected function __construct(mixed $value)
    {
        $this->value = $value;
    }

    public function isEqual(EqualableInterface $other): bool
    {
        if (! ($other instanceof static)) {
            throw new DomainException('Equals exception');
        }

        return $this->value === $other->value;
    }

    public function isNotEqual(EqualableInterface $other): bool
    {
        if (! ($other instanceof static)) {
            throw new DomainException('Equals exception');
        }

        return $this->value !== $other->value;
    }

    public function isNull(): bool
    {
        return $this->value === null;
    }

    public function isNotNull(): bool
    {
        return $this->value !== null;
    }
}