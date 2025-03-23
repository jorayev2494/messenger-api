<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Bus\Queue;

use Illuminate\Contracts\Queue\ShouldQueue;

abstract readonly class Queue implements ShouldQueue
{
    abstract public function handle(): void;
}