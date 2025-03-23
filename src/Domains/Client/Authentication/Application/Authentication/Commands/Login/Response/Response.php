<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Authentication\Commands\Login\Response;

use Project\Shared\Utils\Response\Contracts\HttpResponseInterface;

readonly class Response implements HttpResponseInterface
{
    private function __construct(
        private array $authData
    ) { }

    public static function make(array $authData): self
    {
        return new self($authData);
    }

    public function toHttpResponse(): array
    {
        return $this->authData;
    }
}