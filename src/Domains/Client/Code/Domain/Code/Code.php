<?php

declare(strict_types=1);

namespace Project\Domains\Client\Code\Domain\Code;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Client\Code\Domain\Code\Enums\Type as TypeEnum;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\AuthorUuid;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\Type;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\Value;
use Project\Domains\Client\Code\Infrastructure\Code\Repositories\Doctrine\Types\AuthorUuidType;
use Project\Domains\Client\Code\Infrastructure\Code\Repositories\Doctrine\Types\TypeType;
use Project\Domains\Client\Code\Infrastructure\Code\Repositories\Doctrine\Types\ValueType;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAt;

#[ORM\Entity]
#[ORM\Table(name: 'client_codes')]
#[ORM\HasLifecycleCallbacks]
class Code
{
    use CreatedAtAndUpdatedAt;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: ValueType::NAME, unique: true)]
    private Value $value;

    #[ORM\Column(type: TypeType::NAME, length: 100)]
    private Type $type;

    #[ORM\Column(name: 'author_uuid', type: AuthorUuidType::NAME)]
    private AuthorUuid $authorUuid;

    #[ORM\Column(name: 'expired_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $expiredAt;

    private function __construct(Value $value, Type $type, DateTimeImmutable $expiredAt, AuthorUuid $authorUuid)
    {
        $this->value = $value;
        $this->type = $type;
        $this->expiredAt = $expiredAt;
        $this->authorUuid = $authorUuid;
    }

    public static function fromPrimitives(int $value, TypeEnum $type, DateTimeImmutable $expiredAt, string $authorUuid): self
    {
        return new self(
            Value::fromValue($value),
            Type::fromValue($type->value),
            $expiredAt,
            AuthorUuid::fromValue($authorUuid)
        );
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getType(): Type
    {
        return $this->type;
    }

    public function getExpiredAt(): DateTimeImmutable
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(DateTimeImmutable $value): self
    {
        $this->expiredAt = $value;

        return $this;
    }

    public function setAuthorUuid(AuthorUuid $authorUuid): self
    {
        $this->authorUuid = $authorUuid;

        return $this;
    }

    public function getAuthorUuid(): AuthorUuid
    {
        return $this->authorUuid;
    }
}
