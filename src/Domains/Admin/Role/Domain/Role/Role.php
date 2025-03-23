<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain\Role;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Role\Domain\Member\Member;
use Project\Domains\Admin\Role\Domain\Permission\Permission;
use Project\Domains\Admin\Role\Domain\Permission\PermissionCollection;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\Description;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\IsSuperAdmin;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\Uuid;
use Project\Domains\Admin\Role\Domain\Role\ValueObjects\Value;
use Project\Domains\Admin\Role\Infrastructure\Role\Repositories\Doctrine\Types\DescriptionType;
use Project\Domains\Admin\Role\Infrastructure\Role\Repositories\Doctrine\Types\IsSuperAdminType;
use Project\Domains\Admin\Role\Infrastructure\Role\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\Role\Infrastructure\Role\Repositories\Doctrine\Types\ValueType;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAt;

#[ORM\Entity]
#[ORM\Table(name: 'admin_roles')]
#[ORM\HasLifecycleCallbacks]
class Role
{
    use CreatedAtAndUpdatedAt;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'is_super_admin', type: IsSuperAdminType::NAME, nullable: true, options: ['default' => 0])]
    private IsSuperAdmin $isSuperAdmin;

    #[ORM\Column(type: ValueType::NAME, length: 255, nullable: true)]
    private Value $value;

    #[ORM\Column(type: DescriptionType::NAME, length: 255, nullable: true)]
    private Description $description;

    #[ORM\ManyToMany(targetEntity: Permission::class, inversedBy: 'contests')]
    #[ORM\JoinTable(
        name: 'admin_role_permission',
        joinColumns: new ORM\JoinColumn(name: 'role_uuid', referencedColumnName: 'uuid', nullable: false, onDelete: 'CASCADE'),
        inverseJoinColumns: new ORM\JoinColumn(name: 'permission_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')
    )]
    private Collection $permissions;

    #[ORM\OneToMany(targetEntity: Member::class, mappedBy: 'role', cascade: ['persist', 'remove'])]
    public Collection $members;

    private function __construct(
        Uuid $uuid,
        Value $value,
        Description $description
    )
    {
        $this->uuid = $uuid;
        $this->value = $value;
        $this->description = $description;
        $this->isSuperAdmin = IsSuperAdmin::fromValue(false);
        $this->permissions = new ArrayCollection();
        $this->members = new ArrayCollection();
    }

    public static function create(Uuid $uuid, Value $value, Description $description): self
    {
        return new self($uuid, $value, $description);
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getValue(): Value
    {
        return $this->value;
    }

    public function setValue(Value $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function setDescription(Description $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsSuperAdmin(): IsSuperAdmin
    {
        return $this->isSuperAdmin;
    }

    public function setIsSuperAdmin(IsSuperAdmin $isSuperAdmin): self
    {
        if ($this->isSuperAdmin->isNotEqual($isSuperAdmin)) {
            $this->isSuperAdmin = $isSuperAdmin;
        }

        return $this;
    }

    public function getPermissions(): PermissionCollection
    {
        return PermissionCollection::make($this->permissions->toArray());
    }

    public function addPermission(Permission $permission): self
    {
        if (! $this->permissions->contains($permission)) {
            $this->permissions->add($permission);
        }

        return $this;
    }

    public function clearPermissions(): self
    {
        $this->permissions->clear();

        return $this;
    }
}