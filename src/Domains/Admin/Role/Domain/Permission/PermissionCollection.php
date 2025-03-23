<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain\Permission;

use Project\Shared\Domain\Collection\BaseCollection;

class PermissionCollection extends BaseCollection
{
    protected function className(): string
    {
        return Permission::class;
    }
}