<?php

declare(strict_types=1);

namespace Project\Domains\Institution\Authentication\Presentation\Http\API\REST\Controllers;

use Illuminate\Http\Request;
use Project\Domains\Institution\Authentication\Application\Authentication\Commands\Login\Command;
use Project\Domains\Institution\Authentication\Application\Authentication\Commands\Login\CommandHandler;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class AuthenticationController
{
    public function __construct(
        private ResponseInterface $response
    ) { }

    public function login(Request $request, CommandHandler $handler): JsonResponse
    {
        return $this->response->json(
            $handler(
                new Command(
                    $request->get('email') ?? '',
                    $request->get('password') ?? '',
                )
            )
        );
    }
}