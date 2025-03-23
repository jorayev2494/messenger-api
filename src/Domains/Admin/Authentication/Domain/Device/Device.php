<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Device;

use Project\Domains\Admin\Authentication\Domain\Member\Member;
use Project\Infrastructure\Services\Authentication\Entity\BaseDevice;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'admin_auth_devices')]
#[ORM\HasLifecycleCallbacks]
class Device extends BaseDevice
{
    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'devices')]
    #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Member $author;

    public function getAuthor(): Member
    {
        return $this->author;
    }

    public function setAuthor(Member $author): self
    {
        $this->author = $author;

        return $this;
    }
}