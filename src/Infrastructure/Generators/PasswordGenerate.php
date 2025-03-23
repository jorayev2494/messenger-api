<?php

declare(strict_types=1);

namespace Project\Infrastructure\Generators;

use Project\Infrastructure\Generators\Contracts\PasswordGenerateInterface;

class PasswordGenerate extends TokenGenerator implements PasswordGenerateInterface
{
    public const PASSWORD_LENGTH = 6;

    public function generate(int $length = 6): string
    {
        return ucfirst(parent::generate(($length > self::PASSWORD_LENGTH) ? $length : self::PASSWORD_LENGTH ));
    }
}