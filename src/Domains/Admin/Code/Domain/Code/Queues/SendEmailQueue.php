<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Code\Domain\Code\Queues;

use Project\Domains\Admin\Code\Domain\Code\Code;
use Project\Shared\Domain\Bus\Queue\Queue;

readonly class SendEmailQueue extends Queue
{
    public function __construct(
        private Code $code
    ) { }

    public function handle(): void
    {
        logs()->info(__LINE__, [
            'type' => $this->code->getType()->value,
            'code' => $this->code->getValue()->value,
            'expired_at' => $this->code->getExpiredAt()->format('d-m-Y H:i:s'),
        ]);
    }
}