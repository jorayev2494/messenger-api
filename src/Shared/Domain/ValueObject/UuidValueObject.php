<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Project\Shared\Domain\ValueObject\Contracts\ValueObject;
use Ramsey\Uuid\Uuid;
use Stringable;

/**
 * @property-read string $value
 */
abstract readonly class UuidValueObject extends ValueObject implements Stringable
{
    protected function __construct(?string $value)
    {
        $this->assertIsValidUuid($value);
        parent::__construct($value);
    }

    public static function fromValue(string $value): static
    {
        return new static($value);
    }

    private function assertIsValidUuid(?string $value): void
    {
        if (! is_null($value) && ! Uuid::isValid($value)) {
            throw new InvalidArgumentException(sprintf('`<%s>` does not allow the value `<%s>`.', static::class, $value));
        }
    }

    public final function __toString(): string
    {
        return (string) $this->value;
    }
}