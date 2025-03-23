<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Account\Exceptions;

use Project\Shared\Domain\Exceptions\Contracts\DomainException;
use Symfony\Component\HttpFoundation\Response;

class AccountNotFoundDomainException extends DomainException
{
    public function message(): string
    {
        return 'Account not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}