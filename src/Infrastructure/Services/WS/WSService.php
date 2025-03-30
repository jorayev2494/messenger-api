<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\WS;

use phpcent\Client;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticatableInterface;
use Project\Infrastructure\Services\WS\Contracts\WSServiceInterface;

readonly class WSService implements WSServiceInterface
{
    public function __construct(
        private Client $client
    ) { }

    public function generateConnectionToken(AuthenticatableInterface $authenticatable, array $info = []): string
    {
        return $this->client->generateConnectionToken(
            $authenticatable->getUuid()->value,
            config('ws.centrifuge.ttl'),
            $info
        );
    }

    public function publish(string $channel, array $data): void
    {
        $this->client->publish($channel, $data);
    }

    public function setApiKey(string $key): self
    {
        $this->client->setApiKey($key);

        return $this;
    }
}