<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Client\Queries\Index\Response;

use Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate\Paginator;
use Project\Shared\Utils\Response\Contracts\HttpResponseInterface;

readonly class Response implements HttpResponseInterface
{
    private function __construct(
        private Paginator $paginator
    ) { }

    public static function make(Paginator $paginator): self
    {
        return new self($paginator);
    }

    public function toHttpResponse(): array
    {
        return $this->paginator
            ->map(ClientResponse::make(...))
            ->toArray();
    }
}