<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Device;

use Project\Domains\Client\Authentication\Domain\Account\Account;
use Project\Infrastructure\Services\Authentication\Entity\BaseDevice;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'client_auth_devices')]
#[ORM\HasLifecycleCallbacks]
class Device extends BaseDevice
{
    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'devices')]
    #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Account $author;

    public function getAuthor(): Account
    {
        return $this->author;
    }

    public function setAuthor(Account $author): self
    {
        $this->author = $author;

        return $this;
    }
}