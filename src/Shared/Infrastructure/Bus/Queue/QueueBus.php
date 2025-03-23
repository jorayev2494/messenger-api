<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\Queue;

use Illuminate\Contracts\Bus\QueueingDispatcher;
use Project\Shared\Domain\Bus\Queue\QueueBusInterface;
use Project\Shared\Domain\Bus\Queue\Queue;

readonly class QueueBus implements QueueBusInterface
{
    public function __construct(
        private QueueingDispatcher $dispatcher
    ) { }

    public function dispatch(Queue $command): void
    {
        $this->dispatcher->dispatch($command);
    }
}