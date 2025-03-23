<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure\Account\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Password;

class PasswordType extends Type
{
    public const NAME = 'client_auth_account_password';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Password $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Password
    {
        return Password::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}