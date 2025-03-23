<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Presentation\Http\API\REST\Controllers;

use Project\Domains\Client\Profile\Application\Profile\Queries\Show\Query as ShowQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

readonly class ProfileController
{
    public function __construct(
        private ResponseInterface $response,
        private QueryBusInterface $queryBus
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
            )
        );
    }
}