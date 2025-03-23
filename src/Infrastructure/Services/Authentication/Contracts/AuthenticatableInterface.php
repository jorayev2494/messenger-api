<?php

namespace Project\Infrastructure\Services\Authentication\Contracts;

use Project\Shared\Domain\ValueObject\UuidValueObject;
use Project\Infrastructure\Services\Authentication\ValueObjects\PasswordValueObject;

interface AuthenticatableInterface
{
    public function getUuid(): UuidValueObject;

    public function getClaims(): array;

    public function getPassword(): PasswordValueObject;
}