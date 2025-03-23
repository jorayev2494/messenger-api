<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Member\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Role\Domain\Member\ValueObjects\RoleUuid;

class RoleUuidType extends Type
{
    public const NAME = 'admin_role_member_role_uuid';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    /**
     * @param RoleUuid $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): RoleUuid
    {
        return RoleUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}