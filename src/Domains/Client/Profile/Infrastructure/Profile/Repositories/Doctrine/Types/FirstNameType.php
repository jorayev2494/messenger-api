<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Infrastructure\Profile\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Profile\Domain\Profile\ValueObjects\FirstName;

class FirstNameType extends Type
{
    public const NAME = 'client_profile_first_name';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
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