<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Client\Queries\Show\Response;

use Project\Domains\Admin\Client\Domain\Client\Client;
use Project\Shared\Utils\Response\Contracts\HttpResponseInterface;

readonly class Response implements HttpResponseInterface
{
    private function __construct(
        private ClientResponse $ClientResponse
    ) { }

    public static function make(Client $Client): self
    {
        return new self(
            ClientResponse::make($Client)
        );
    }

    public function toHttpResponse(): array
    {
        return $this->ClientResponse->toArray();
    }
}