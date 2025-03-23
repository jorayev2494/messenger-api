<?php

namespace Project\Shared\Domain\Bus\Queue;

interface QueueBusInterface
{
    public function dispatch(Queue $command): void;
}