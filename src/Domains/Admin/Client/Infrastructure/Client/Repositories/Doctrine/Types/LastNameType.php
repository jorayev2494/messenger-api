<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Infrastructure\Client\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\LastName;

class LastNameType extends Type
{
    public const NAME = 'admin_client_last_name';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param LastName $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): LastName
    {
        return LastName::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}