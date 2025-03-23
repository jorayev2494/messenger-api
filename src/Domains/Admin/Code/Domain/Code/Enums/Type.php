<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Code\Domain\Code\Enums;

use OpenApi\Attributes as OA;

#[OA\Schema(type: 'string', schema: 'Admin:Code:Type')]
enum Type : string
{
    case RESTORE_PASSWORD = 'restore_password';
}