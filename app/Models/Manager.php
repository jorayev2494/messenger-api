<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Auth\Authenticatable;
use Illuminate\Support\Arr;
use Project\Domains\Admin\Authentication\Domain\Member\Member;
use DateTimeImmutable;
use Project\Domains\Admin\Role\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Member\ValueObjects\Uuid;
use Project\Domains\Admin\Role\Domain\Member\Member as RoleMember;
use Project\Domains\Admin\Role\Domain\Permission\Permission;

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

    public function getJWTCustomClaims(): array
    {
        $foundMember = resolve(MemberRepositoryInterface::class)->findByUuid(Uuid::fromValue($this->getKey()));

        $role = [];

        if ($foundMember instanceof RoleMember) {
            $role = [
                'uuid' => $foundMember->getRole()->getUuid()->value,
                'value' => $foundMember->getRole()->getValue()->value,
                'is_super_admin' => $foundMember->getRole()->getIsSuperAdmin()->value,
                'permissions' => $foundMember->getRole()->getPermissions()->map(static fn (Permission $permission): array => [
                    'resource' => $permission->getResource()->value,
                    'action' => $permission->getAction()->value,
                ])->toArray(),
            ];
        }

        return compact('role');
    }
}
