<?php

declare(strict_types=1);

namespace Project\Domains\Client\Code\Infrastructure\Code\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\Type;

class TypeType extends \Doctrine\DBAL\Types\Type
{
    public const NAME = 'client_code_type';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Type $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Type
    {
        return Type::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}