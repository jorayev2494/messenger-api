<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\WS\Contracts;

use Project\Infrastructure\Services\Authentication\Contracts\AuthenticatableInterface;

interface WSServiceInterface
{
    public function generateConnectionToken(AuthenticatableInterface $authenticatable, array $info = []): string;
    
    public function publish(string $channel, array $data): void;

    public function setApiKey(string $key): self;
}