<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authentication;

use Project\Domains\Admin\Authentication\Domain\Member\Member;
use Project\Domains\Client\Authentication\Domain\Account\Account;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use Illuminate\Support\Facades\Auth as BaseAuth;

readonly class Auth
{
    public static function account(): ?Account
    {
        return match (true) {
            BaseAuth::guard(GuardType::MANAGER->value)->check() => self::manager(),
            BaseAuth::guard(GuardType::CLIENT->value)->check() => self::client(),
            default => null
        };
    }

    public static function manager(): ?Member
    {
        return BaseAuth::guard(GuardType::MANAGER->value)->user()?->toAccount();
    }

    public static function client(): ?Account
    {
        return BaseAuth::guard(GuardType::CLIENT->value)->user()?->toAccount();
    }

    public static function check(GuardType $guard = null): bool
    {
        return BaseAuth::guard($guard ? $guard->value : GuardType::guard())->check();
    }
}