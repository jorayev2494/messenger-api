<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\Action;

class ActionType extends Type
{
    public const NAME = 'admin_role_permission_action';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Action $value
     * @param AbstractPlatform $platform
     * @return ?string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Action
    {
        return Action::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
