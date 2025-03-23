<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

final class DomainException extends \Project\Shared\Domain\Exceptions\Contracts\DomainException
{
    public function message(): string
    {
        return $this->message;
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}