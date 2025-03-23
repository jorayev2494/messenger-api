<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Domain\Profile;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Client\Profile\Domain\Profile\ValueObjects\FirstName;
use Project\Domains\Client\Profile\Domain\Profile\ValueObjects\Uuid;
use Project\Domains\Client\Profile\Infrastructure\Profile\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Client\Profile\Infrastructure\Profile\Repositories\Doctrine\Types\FirstNameType;
use Project\Domains\Client\Profile\Infrastructure\Profile\Repositories\Doctrine\Types\LastNameType;
use Project\Domains\Client\Profile\Infrastructure\Profile\Repositories\Doctrine\Types\EmailType;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAt;

#[ORM\Entity]
#[ORM\Table(name: 'client_profiles')]
#[ORM\HasLifecycleCallbacks]
class Profile
{
    use CreatedAtAndUpdatedAt;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'first_name', type: FirstNameType::NAME, length: 75, nullable: true)]
    private FirstName $firstName;

    #[ORM\Column(name: 'last_name', type: LastNameType::NAME, length: 75, nullable: true)]
    private FirstName $lastName;

    #[ORM\Column(type: EmailType::NAME, length: 75, unique: true)]
    private FirstName $email;

    public function __construct(
        Uuid $uuid,
        FirstName $firstName,
        FirstName $lastName,
        FirstName $email
    ) { }
}