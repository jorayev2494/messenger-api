<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Auth\Authenticatable;
use Illuminate\Support\Arr;
use Project\Domains\Admin\Authentication\Domain\Member\Member;
use DateTimeImmutable;

class Manager extends Authenticatable
{
    protected $table = 'admin_auth_members';

    // protected $connection = 'admin_db';

    public function toAccount(): Member
    {
        return Member::fromPrimitives(
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
