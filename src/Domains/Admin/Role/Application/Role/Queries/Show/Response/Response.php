<?php

namespace Project\Domains\Admin\Role\Application\Role\Queries\Show\Response;

use Project\Domains\Admin\Role\Domain\Role\Role;
use Project\Shared\Utils\Response\Contracts\HttpResponseInterface;

readonly class Response implements HttpResponseInterface
{
    private function __construct(
        private RoleResponse $roleResponse
    ) { }

    public static function make(Role $role): self
    {
        return new self(
            RoleResponse::make($role)
        );
    }

    public function toHttpResponse(): array
    {
        return $this->roleResponse->toHttpResponse();
    }
}