<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Queries\Show\Response;

use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Shared\Utils\Response\Contracts\HttpResponseInterface;

readonly class Response implements HttpResponseInterface
{
    private function __construct(
        private ManagerResponse $managerResponse
    ) { }

    public static function make(Manager $manager): self
    {
        return new self(
            ManagerResponse::make($manager)
        );
    }

    public function toHttpResponse(): array
    {
        return $this->managerResponse->toArray();
    }
}