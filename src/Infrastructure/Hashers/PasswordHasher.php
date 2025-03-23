<?php

declare(strict_types=1);

namespace Project\Infrastructure\Hashers;

use Illuminate\Support\Facades\Hash;
use Project\Infrastructure\Hashers\Contracrs\PasswordHasherInterface;
use Project\Infrastructure\Services\Authentication\ValueObjects\PasswordValueObject;

class PasswordHasher implements PasswordHasherInterface
{

    public function hash(string $value): string
    {
        return bcrypt($value);
    }

    public function check(string $password, PasswordValueObject $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword->value);
    }
}