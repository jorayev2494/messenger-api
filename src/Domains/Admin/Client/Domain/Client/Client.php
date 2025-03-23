<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Domain\Client;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Client\Domain\Client\Events\ClientEmailWasChangedDomainEvent;
use Project\Domains\Admin\Client\Domain\Client\Events\ClientWasCreatedDomainEvent;
use Project\Domains\Admin\Client\Domain\Client\Events\ClientWasDeletedDomainEvent;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\Uuid;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\Email;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\FirstName;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\LastName;
use Project\Domains\Admin\Client\Infrastructure\Client\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\Client\Infrastructure\Client\Repositories\Doctrine\Types\EmailType;
use Project\Domains\Admin\Client\Infrastructure\Client\Repositories\Doctrine\Types\FirstNameType;
use Project\Domains\Admin\Client\Infrastructure\Client\Repositories\Doctrine\Types\LastNameType;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAt;

#[ORM\Entity]
#[ORM\Table(name: 'admin_clients')]
#[ORM\HasLifecycleCallbacks]
// #[ORM\Index(name: 'first_name_and_last_name_idx', columns: ['first_name', 'last_name'])]
class Client extends AggregateRoot
{
    use CreatedAtAndUpdatedAt;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: EmailType::NAME, length: 75, unique: true)]
    private Email $email;

    #[ORM\Column(name: 'first_name', type: FirstNameType::NAME, length: 75, nullable: true)]
    private FirstName $firstName;

    #[ORM\Column(name: 'last_name', type: LastNameType::NAME, length: 75, nullable: true)]
    private LastName $lastName;

    public function __construct(
        Uuid $uuid,
        Email $email,
        FirstName $firstName,
        LastName $lastName
    ) {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function create(Uuid $uuid, Email $email, FirstName $firstName, LastName $lastName): self
    {
        $manager = new self($uuid, $email, $firstName, $lastName);
        $manager->record(
            new ClientWasCreatedDomainEvent(
                $uuid->value,
                $email->value
            )
        );

        return $manager;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function changeEmail(Email $email): self
    {
        if ($this->email->isNotEqual($email)) {
            $this->email = $email;
            $this->record(
                new ClientEmailWasChangedDomainEvent(
                    $this->uuid->value,
                    $this->email->value
                )
            );
        }

        return $this;
    }

    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    public function changeFirstName(FirstName $firstName): self
    {
        if ($this->firstName->isNotEqual($firstName)) {
            $this->firstName = $firstName;
        }

        return $this;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function changeLastName(LastName $lastName): self
    {
        if ($this->lastName->isNotEqual($lastName)) {
            $this->lastName = $lastName;
        }

        return $this;
    }

    public function delete(): void
    {
        $this->record(
            new ClientWasDeletedDomainEvent(
                $this->uuid->value
            )
        );
    }
}