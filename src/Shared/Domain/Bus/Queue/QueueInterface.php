<?php

namespace Project\Shared\Domain\Bus\Queue;

use Illuminate\Contracts\Queue\ShouldQueue;

interface QueueInterface extends ShouldQueue
{
    public function handle(): void;
}