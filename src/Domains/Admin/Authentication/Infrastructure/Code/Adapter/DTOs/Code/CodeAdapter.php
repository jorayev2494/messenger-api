<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Code\Adapter\DTOs\Code;

use Project\Domains\Admin\Authentication\Infrastructure\Code\Adapter\Contracts\CodeApiInterface;
use Project\Domains\Admin\Authentication\Infrastructure\Code\Adapter\DTOs\Code\VOs\Id;
use Project\Domains\Admin\Authentication\Infrastructure\Code\Adapter\DTOs\Code\VOs\Type;
use Project\Domains\Admin\Authentication\Infrastructure\Code\Adapter\DTOs\Code\VOs\Value;

readonly class CodeAdapter
{
    public function __construct(
        private CodeApiInterface $api
    ) { }

    public function findByValue(Value $value): ?CodeDTO
    {
        $code = $this->api->findByValue($value);

        if ($code === null) {
            return null;
        }

        return CodeDTO::makeFromArray($code);
    }

    public function delete(Id $id): void
    {
        $this->api->delete($id->value);
    }
}