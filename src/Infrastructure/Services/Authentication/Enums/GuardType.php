<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authentication\Enums;

use Illuminate\Support\Facades\Auth;

enum GuardType : string
{
    case MANAGER = 'manager';

    case CLIENT = 'client';

    public static function guard(): ?string
    {
        return match (true) {
            Auth::guard(self::MANAGER->value)->check() => self::MANAGER->value,
            Auth::guard(self::CLIENT->value)->check() => self::CLIENT->value,
            default => null
        };
    }
}
