<?php

declare(strict_types=1);

namespace Project\Domains\Client\Code\Domain\Code\Enums;

use OpenApi\Attributes as OA;

#[OA\Schema(type: 'string', schema: 'Client:Code:Type')]
enum Type : string
{
    case RESTORE_PASSWORD = 'restore_password';
}