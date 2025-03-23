<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Account\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class AccountPasswordWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $accountUuid,
        public string $type,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($this->accountUuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'account_uuid' => $accountUuid,
            'type' => $type,
        ] = $body;

        return new self($accountUuid, $type, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'client.authentication.account_password_was_changed';
    }

    public function toArray(): array
    {
        return [
            'account_uuid' => $this->accountUuid,
            'type' => $this->type,
        ];
    }
}