<?php

declare(strict_types=1);

namespace App\Models\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

abstract class JWTAuthenticatable extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier(): string
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}