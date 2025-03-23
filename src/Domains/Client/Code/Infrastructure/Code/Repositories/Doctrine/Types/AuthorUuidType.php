<?php

declare(strict_types=1);

namespace Project\Domains\Client\Code\Infrastructure\Code\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\AuthorUuid;

class AuthorUuidType extends Type
{
    public const NAME = 'client_code_author_uuid';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    /**
     * @param AuthorUuid $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): AuthorUuid
    {
        return AuthorUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}