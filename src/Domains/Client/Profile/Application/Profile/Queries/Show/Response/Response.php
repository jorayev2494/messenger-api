<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Application\Profile\Queries\Show\Response;

use Project\Domains\Admin\Profile\Infrastructure\Adapters\Manager\DTOs\ManagerDTO;
use Project\Shared\Utils\Response\Contracts\HttpResponseInterface;

readonly class Response implements HttpResponseInterface
{
    private function __construct(
        private ManagerDTO $profile
    ) { }

    public static function make(ManagerDTO $profile): self
    {
        return new self($profile);
    }

    public function toHttpResponse(): array
    {
        return [
            'email' => $this->profile->email->value,
            'first_name' => $this->profile->firstName->value,
            'last_name' => $this->profile->lastName->value,
        ];
    }
}