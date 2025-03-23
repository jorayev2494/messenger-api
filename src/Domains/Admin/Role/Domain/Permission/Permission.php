<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain\Permission;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\Action;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\Id;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\Label;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\Resource;
use Project\Domains\Admin\Role\Domain\Role\Role;
use Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine\Types\ActionType;
use Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine\Types\IdType;
use Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine\Types\LabelType;
use Project\Domains\Admin\Role\Infrastructure\Permission\Repositories\Doctrine\Types\ResourceType;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAt;

#[ORM\Entity]
#[ORM\Table(name: 'admin_role_permissions')]
#[ORM\HasLifecycleCallbacks]
class Permission
{
    use CreatedAtAndUpdatedAt;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: IdType::NAME)]
    private Id $id;

    #[ORM\Column(type: LabelType::NAME, length: 255, nullable: true)]
    private Label $label;

    #[ORM\Column(type: ResourceType::NAME, length: 255)]
    private Resource $resource;

    #[ORM\Column(type: ActionType::NAME, length: 255)]
    private Action $action;

    #[ORM\ManyToMany(targetEntity: Role::class, mappedBy: 'permissions')]
    private Collection $roles;

    public function __construct(
        Label $label,
        Resource $resource,
        Action $action
    )
    {
        $this->label = $label;
        $this->resource = $resource;
        $this->action = $action;
        $this->roles = new ArrayCollection();
    }

    public static function create(
        Label $label,
        Resource $resource,
        Action $action
    ): self
    {
        return new self($label, $resource, $action);
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getLabel(): Label
    {
        return $this->label;
    }

    public function getResource(): Resource
    {
        return $this->resource;
    }

    public function getAction(): Action
    {
        return $this->action;
    }
}