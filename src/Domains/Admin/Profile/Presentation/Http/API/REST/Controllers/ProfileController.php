<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Presentation\Http\API\REST\Controllers;

use Illuminate\Http\Request;
use Project\Domains\Admin\Profile\Application\Profile\Commands\Update\Command;
use Project\Domains\Admin\Profile\Application\Profile\Queries\Show\Query as ShowQuery;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

readonly class ProfileController
{
    public function __construct(
        private ResponseInterface $response,
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    ) { }

    #[OA\Get(
        path: '/profile',
        summary: 'Get profile',
        tags: ['Profile'],
        security: [
            [
                'authBearerToken' => [],
            ],
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Profile Response'
            )
        ]
    )]
    public function show(): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ShowQuery()
            )->toHttpResponse()
        );
    }

    #[OA\Put(
        path: '/profile',
        summary: 'Update profile',
        tags: ['Profile'],
        security: [
            [
                'authBearerToken' => [],
            ],
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: '#/components/schemas/Admin:Profile:UpdateRequestBodySchema',
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: 'Profile update response'
            )
        ]
    )]
    public function update(Request $request): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $request->get('email') ?? '',
                $request->get('first_name') ?? '',
                $request->get('last_name') ?? ''
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}