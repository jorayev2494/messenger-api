<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Domain\Client\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class ClientEmailWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $email,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($this->uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'uuid' => $uuid,
            'email' => $email,
        ] = $body;

        return new self($uuid, $email, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_client_email.was.changed';
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'email' => $this->email,
        ];
    }
}