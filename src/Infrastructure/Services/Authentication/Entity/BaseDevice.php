<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authentication\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Infrastructure\Services\Authentication\Contracts\DeviceInterface;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAt;

abstract class BaseDevice implements DeviceInterface
{
    use CreatedAtAndUpdatedAt;

    #[ORM\Id]
    #[ORM\Column(type: Types::STRING)]
    protected string $uuid;

    #[ORM\Column(name: 'refresh_token', type: Types::STRING, unique: true)]
    protected string $refreshToken;

    #[ORM\Column(name: 'device_id', type: Types::STRING)]
    protected string $deviceId;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    protected string $os;

    #[ORM\Column(name: 'os_version', type: Types::STRING, nullable: true)]
    protected string $osVersion;

    #[ORM\Column(name: 'app_version', type: Types::STRING, nullable: true)]
    protected string $appVersion;

    #[ORM\Column(name: 'ip_address', type: Types::STRING, nullable: true)]
    protected string $idAddress;

    #[ORM\Column(name: 'author_uuid', type: Types::STRING)]
    protected string $authorUuid;

    # #[ORM\ManyToOne(targetEntity: Manager::class, inversedBy: 'devices')]
    # #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid', nullable: false)]
    # private Manager $author;

    protected function __construct(
        string $uuid,
        string $refreshToken,
        string $deviceId
    ) {
        $this->uuid = $uuid;
        $this->refreshToken = $refreshToken;
        $this->deviceId = $deviceId;
    }

    public static function fromPrimitives(string $uuid, string $refreshToken, string $deviceId): static
    {
        return new static($uuid, $refreshToken, $deviceId);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

//    public function getAuthor(): AuthenticatableInterface
//    {
//        return $this->author;
//    }
//
//    public function setAuthor(AuthenticatableInterface $author): self
//    {
//        $this->author = $author;
//
//        return $this;
//    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    public function getDeviceId(): string
    {
        return $this->deviceId;
    }
}