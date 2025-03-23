<?php

declare(strict_types=1);

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Authenticatable extends JWTAuthenticatable
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'uuid';

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $hidden = [
        'password',
        'remember_token',
    ];
}