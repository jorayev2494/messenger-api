<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Member\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class MemberPasswordWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $memberUuid,
        public string $type,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($this->memberUuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'member_uuid' => $memberUuid,
            'type' => $type,
        ] = $body;

        return new self($memberUuid, $type, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin.authentication.member_password_was_changed';
    }

    public function toArray(): array
    {
        return [
            'member_uuid' => $this->memberUuid,
            'type' => $this->type,
        ];
    }
}