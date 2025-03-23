<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Exceptions\Contracts;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class DomainException extends \DomainException
{
    public function __construct(string $message = '', int $code = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($message ?: $this->message(), $code);
    }

    abstract public function message(): string;

    abstract public function getHttpResponseCode(): int;

    public function response(): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->getMessage(),
        ], $this->getHttpResponseCode());
    }
}