<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Infrastructure\Client\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\FirstName;

class FirstNameType extends Type
{
    public const NAME = 'admin_client_first_name';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param FirstName $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): FirstName
    {
        return FirstName::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}