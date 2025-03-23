<?php

namespace Project\Shared\Domain\Bus\Event;

interface EventBusInterface
{
    public function publish(DomainEvent ...$events): void;
}