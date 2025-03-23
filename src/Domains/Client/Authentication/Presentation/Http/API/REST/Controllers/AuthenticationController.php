<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Presentation\Http\API\REST\Controllers;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Project\Domains\Client\Authentication\Application\Authentication\Commands\Login\Command as LoginCommand;
use Project\Domains\Client\Authentication\Application\Authentication\Commands\Login\CommandHandler as LoginCommandHandler;
use Project\Domains\Client\Authentication\Application\Authentication\Commands\Register\Command as RegisterCommand;
use Project\Domains\Client\Authentication\Application\Authentication\Commands\RefreshToken\Command as RefreshTokenCommand;
use Project\Domains\Client\Authentication\Application\Authentication\Commands\RefreshToken\CommandHandler as RefreshTokenCommandHandler;
use Project\Domains\Client\Authentication\Application\Authentication\Commands\Logout\Command as LogoutCommand;
use Project\Domains\Client\Authentication\Application\Authentication\Commands\RestorePassword\Command;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


readonly class AuthenticationController
{
    public function __construct(
        private ResponseInterface $response,
        private UuidGeneratorInterface $uuidGenerator,
        private CommandBusInterface $commandBus
    ) { }

    #[OA\Post(
        path: '/auth/login',
        summary: 'Login',
        tags: ['Authentication'],
        parameters: [
            new OA\Parameter(
                in: 'header',
                name: 'X-Device-Id',
                example: 'EgZjaHJvbWUyBggAEEUY',
                required: true
            )
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    type: 'object',
                    required: [
                        'email',
                        'password',
                    ],
                    properties: [
                        new OA\Property(
                            type: 'string',
                            property: 'email',
                            example: 'client@gmail.com'
                        ),
                        new OA\Property(
                            type: 'string',
                            property: 'password',
                            example: '12345Secret!'
                        )
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Success response'
            )
        ]
    )]
    public function login(Request $request, LoginCommandHandler $commandHandler): JsonResponse
    {
        $command = new LoginCommand(
            $request->headers->get('x-device-id') ?? '',
            $request->get('email') ?? '',
            $request->get('password') ?? '',
        );

        $command->validate();

        return $this->response->json(
            $commandHandler($command)->toHttpResponse()
        );
    }

    public function register(Request $request): Response
    {
        $this->commandBus->dispatch(
            new RegisterCommand(
                $this->uuidGenerator->generate(),
                $request->get('email') ?? '',
                $request->get('password') ?? '',
                $request->get('password_confirmation') ?? '',
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    #[OA\Post(
        path: '/auth/refresh-token',
        summary: 'Refresh token',
        tags: ['Authentication'],
        parameters: [
            new OA\Parameter(
                in: 'header',
                name: 'X-Device-Id',
                example: 'EgZjaHJvbWUyBggAEEUY',
                required: true
            )
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    type: 'object',
                    required: [
                        'refresh-token',
                    ],
                    properties: [
                        new OA\Property(
                            type: 'string',
                            property: 'refresh-token',
                            example: '6b79869159988ca96646a31ae5435d60'
                        ),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Success response'
            )
        ]
    )]
    public function refreshToken(Request $request, RefreshTokenCommandHandler $commandHandler): JsonResponse
    {
        $command = new RefreshTokenCommand(
            $request->headers->get('x-device-id') ?? '',
            $request->get('refresh-token') ?? ''
        );

        $command->validate();

        return $this->response->json(
            $commandHandler($command)->toHttpResponse()
        );
    }

    #[OA\Post(
        path: '/auth/logout',
        summary: 'Refresh token',
        tags: ['Authentication'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OA\Parameter(
                in: 'header',
                name: 'X-Device-Id',
                example: 'EgZjaHJvbWUyBggAEEUY',
                required: true
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_NO_CONTENT,
                description: 'Success response'
            )
        ]
    )]
    public function logout(Request $request): Response
    {
        $this->commandBus->dispatch(
            new LogoutCommand(
                $request->headers->get('x-device-id') ?? ''
            )
        );

        return $this->response->noContent();
    }

    #[OA\Post(
        path: '/auth/restore-password',
        summary: 'Restore password',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    type: 'object',
                    required: [
                        'code',
                    ],
                    properties: [
                        new OA\Property(
                            type: 'integer',
                            property: 'code',
                            example: 563894
                        ),
                        new OA\Property(
                            type: 'string',
                            property: 'password',
                            example: '12345NewSecret!'
                        ),
                        new OA\Property(
                            type: 'string',
                            property: 'password_confirmation',
                            example: '12345NewSecret!'
                        ),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: 'Success response'
            )
        ]
    )]
    public function restorePassword(Request $request): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $request->integer('code'),
                $request->get('password') ?? '',
                $request->get('password_confirmation') ?? ''
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}