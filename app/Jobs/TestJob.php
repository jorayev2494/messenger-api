<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

readonly class TestJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private string $text
    ) { }

    public function handle(): void
    {
        logs()->info($this->text);
    }
}
