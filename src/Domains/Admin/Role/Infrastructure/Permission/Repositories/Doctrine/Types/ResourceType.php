<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\Resource;

class ResourceType extends Type
{
    public const NAME = 'admin_role_permission_resource';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Resource $value
     * @param AbstractPlatform $platform
     * @return ?string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Resource
    {
        return Resource::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
