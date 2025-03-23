<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Profile\Queries\Show\Response;

use Project\Shared\Utils\Response\Contracts\HttpResponseInterface;

readonly class Response implements HttpResponseInterface
{
    private function __construct(
        private array $data
    ) { }

    public static function make(array $data): self
    {
        return new self($data);
    }

    public function toHttpResponse(): array
    {
        return $this->data;
    }
}