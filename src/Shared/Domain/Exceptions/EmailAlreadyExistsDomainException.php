<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Exceptions;

use Project\Shared\Domain\Exceptions\Contracts\DomainException;
use Symfony\Component\HttpFoundation\Response;

class EmailAlreadyExistsDomainException extends DomainException
{
    public function message(): string
    {
        return 'The email already exists';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}