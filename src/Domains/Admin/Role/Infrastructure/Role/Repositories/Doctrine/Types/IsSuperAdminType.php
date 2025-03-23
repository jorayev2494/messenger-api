<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Role\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\IsSuperAdmin;

class IsSuperAdminType extends Type
{
    public const NAME = 'admin_role_is_super_admin';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getBooleanTypeDeclarationSQL($column);
    }

    /**
     * @param IsSuperAdmin $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value ? '1' : '0';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): IsSuperAdmin
    {
        return IsSuperAdmin::fromValue((bool) $value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}