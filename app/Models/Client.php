<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Auth\Authenticatable;
use Illuminate\Support\Arr;
use Project\Domains\Client\Authentication\Domain\Account\Account;
use DateTimeImmutable;

class Client extends Authenticatable
{
    protected $table = 'client_auth_accounts';

    public function toAccount(): Account
    {
        return Account::fromPrimitives(
            ...Arr::except(
                $this->getAttributes(),
                [
                    'created_at',
                    'updated_at',
                ]
            )
        )
            ->setCreatedAt(new DateTimeImmutable($this->getAttributeValue('created_at')))
            ->setUpdatedAt(new DateTimeImmutable($this->getAttributeValue('updated_at')));
    }
}
