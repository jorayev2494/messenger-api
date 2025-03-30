<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain\Member;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Role\Domain\Member\ValueObjects\RoleUuid;
use Project\Domains\Admin\Role\Domain\Member\ValueObjects\Uuid;
use Project\Domains\Admin\Role\Domain\Role\Role;
use Project\Domains\Admin\Role\Infrastructure\Member\Repositories\Doctrine\Types\RoleUuidType;
use Project\Domains\Admin\Role\Infrastructure\Member\Repositories\Doctrine\Types\UuidType;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAt;

#[ORM\Entity]
#[ORM\Table(name: 'admin_role_members')]
#[ORM\HasLifecycleCallbacks]
class Member
{
    use CreatedAtAndUpdatedAt;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

     #[ORM\Column(name: 'role_uuid', type: RoleUuidType::NAME, nullable: true, unique: false)]
     private RoleUuid $roleUuid;

    // #[ORM\Column(name: 'role_uuid', type: RoleUuidType::NAME, nullable: true, unique: false)]
    // private RoleUuid $roleUuid;

    #[ORM\ManyToOne(targetEntity: Role::class, fetch: 'LAZY', inversedBy: 'members')]
    #[ORM\JoinColumn(name: 'role_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private ?Role $role;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
        $this->roleUuid = RoleUuid::fromValue(null);
        $this->role = null;
    }

    public static function create(Uuid $uuid): self
    {
        return new self($uuid);
    }

    public function changeRole(Role $role): self
    {
        if ($isEqual = $this->roleUuid->isNotEqual($roleUuid = RoleUuid::fromValue($role->getUuid()->value))) {
            $this->roleUuid = $roleUuid;
        }

        logs()->info('Role member change role is equal: ', ['val' => $isEqual]);

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->roleUuid->isNotNull() ? $this->role : null;
    }
}