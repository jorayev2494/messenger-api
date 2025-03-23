<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Member;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Authentication\Domain\Device\Device;
use Project\Domains\Admin\Authentication\Domain\Member\Events\MemberPasswordWasChangedDomainEvent;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Email;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Password;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Uuid;
use Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Types\EmailType;
use Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Types\PasswordType;
use Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Types\UuidType;
use Project\Domains\Admin\Code\Domain\Code\Enums\Type;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticatableInterface;
use Project\Infrastructure\Services\Authentication\Contracts\DeviceableInterface;
use Project\Infrastructure\Services\Authentication\Traits\Deviceable;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAt;

#[ORM\Entity]
#[ORM\Table(name: 'admin_auth_members')]
#[ORM\HasLifecycleCallbacks]
class Member extends AggregateRoot implements AuthenticatableInterface, DeviceableInterface
{
    use Deviceable, CreatedAtAndUpdatedAt;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $uuid;

    #[ORM\Column(type: EmailType::NAME, length: 100, unique: true)]
    private Email $email;

    #[ORM\Column(type: PasswordType::NAME, length: 100)]
    private Password $password;

    #[ORM\OneToMany(targetEntity: Device::class, mappedBy: 'author', cascade: ['persist', 'remove'])]
    private Collection $devices;

    private function __construct(Uuid $uuid, Email $email, Password $password)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->password = $password;
        $this->devices = new ArrayCollection();
    }

    public static function create(Uuid $uuid, Email $email, Password $password): self
    {
        return new self($uuid, $email, $password);
    }

    public static function fromPrimitives(string $uuid, string $email, string $password): self
    {
        return new self(
            Uuid::fromValue($uuid),
            Email::fromValue($email),
            Password::fromValue($password)
        );
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getClaims(): array
    {
        return [];
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function changePassword(Password $password): self
    {
        $this->password = $password;
        // $this->record(
        //     new MemberPasswordWasChangedDomainEvent(
        //         $this->uuid->value,
        //         Type::RESTORE_PASSWORD->value
        //     )
        // );

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersisting(PrePersistEventArgs $event): void
    {
        $this->createdAt = $this->createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();

        if ($this->createdAt->getTimestamp() === $this->updatedAt->getTimestamp()) {
            $this->password = Password::fromValue($this->password->hash());
        }
    }
}