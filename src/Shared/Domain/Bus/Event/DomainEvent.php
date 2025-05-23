<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Bus\Event;

use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

abstract readonly class DomainEvent implements Event
{
    private string $eventId;

    private string $occurredOn;

    public function __construct(private string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        $this->eventId = $eventId ?: resolve(UuidGeneratorInterface::class)->generate();
        $this->occurredOn = $occurredOn ?: (new \DateTimeImmutable())->format('Y-m-d H:i:s.u T');
        // $this->occurredOn = $occurredOn ?: (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM);
    }

    abstract public static function fromPrimitives(
        string $id,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    abstract public static function eventName(): string;

    final public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    final public function eventId(): string
    {
        return $this->eventId;
    }

    final public function occurredOn(): string
    {
        return $this->occurredOn;
    }

    // public static function exchangeName(): string
    // {
    //     return 'shop.exchange';
    // }
}