<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\Id;

class IdType extends Type
{
    public const NAME = 'admin_role_permission_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    /**
     * @param Id $value
     * @param AbstractPlatform $platform
     * @return int
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): int
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Id
    {
        return Id::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
