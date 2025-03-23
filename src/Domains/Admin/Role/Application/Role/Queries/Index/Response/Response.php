<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Role\Queries\Index\Response;

use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate\Paginator;

readonly class Response implements ArrayableInterface
{
    private function __construct(
        private Paginator $paginator
    ) { }

    public static function make(Paginator $paginator): self
    {
        return new self($paginator);
    }

    public function toArray(): array
    {
        return $this->paginator->map(RoleResponse::make(...))->toArray();
    }
}