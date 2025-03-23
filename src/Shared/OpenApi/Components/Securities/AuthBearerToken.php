<?php

declare(strict_types=1);

namespace Project\Shared\OpenApi\Components\Securities;

readonly class AuthBearerToken
{
    public static function make(): array
    {
        return [
            'authBearerToken' => [],
        ];
    }
}