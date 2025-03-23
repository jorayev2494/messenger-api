<?php

declare(strict_types=1);

namespace Project\Domains\Institution\Authentication\Domain\Account;

use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Institution\Authentication\Domain\Account\ValueObjects\Email;
use Project\Domains\Institution\Authentication\Domain\Account\ValueObjects\Password;
use Project\Domains\Institution\Authentication\Domain\Account\ValueObjects\Uuid;
use Project\Domains\Institution\Authentication\Infrastructure\Account\Repositories\Doctrine\Types\EmailType;
use Project\Domains\Institution\Authentication\Infrastructure\Account\Repositories\Doctrine\Types\PasswordType;
use Project\Domains\Institution\Authentication\Infrastructure\Account\Repositories\Doctrine\Types\UuidType;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAt;

#[ORM\Entity]
#[ORM\Table(name: 'institution_auth_accounts')]
#[ORM\HasLifecycleCallbacks]
class Account
{
    use CreatedAtAndUpdatedAt;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $uuid;

    #[ORM\Column(type: EmailType::NAME, length: 100, unique: true)]
    private Email $email;

    #[ORM\Column(type: PasswordType::NAME, length: 100)]
    private Password $password;

    private function __construct(Uuid $uuid, Email $email, Password $password)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->password = $password;
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
