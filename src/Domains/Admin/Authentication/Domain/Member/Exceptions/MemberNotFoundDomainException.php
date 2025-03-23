<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Member\Exceptions;

use Project\Shared\Domain\Exceptions\Contracts\DomainException;
use Symfony\Component\HttpFoundation\Response;

class MemberNotFoundDomainException extends DomainException
{
    public function message(): string
    {
        return 'Member not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}