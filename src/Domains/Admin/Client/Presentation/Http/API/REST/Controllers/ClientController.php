<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Presentation\Http\API\REST\Controllers;

use Illuminate\Http\Request;
use Project\Domains\Admin\Client\Application\Client\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Client\Application\Client\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Client\Application\Client\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\Client\Application\Client\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Client\Application\Client\Commands\Delete\Command as DeleteCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Project\Shared\OpenApi\Components as OAC;

readonly class ClientController
{
    public function __construct(
        private ResponseInterface $response,
        private UuidGeneratorInterface $uuidGenerator,
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    ) { }

    #[OA\Get(
        path: '/clients',
        summary: 'Client paginate',
        tags: ['Clients'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OAC\Parameters\Queries\PageParameter(),
            new OAC\Parameters\Queries\PerPageParameter(),
        ],
        responses: [
            new OAC\Responses\PaginateResponse(
                dataRef: '#/components/schemas/Admin:Client:IndexResponseSchema'
            ),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                IndexQuery::makeFromRequest($request)
            )
        );
    }

    #[OA\Post(
        path: '/clients',
        summary: 'Create a client',
        tags: ['Clients'],
        security: [
            ['authBearerToken' => []],
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: '#/components/schemas/Admin:Client:CreateRequestBodySchema',
            )
        ),
        responses: [
            new OAC\Responses\CreatedResponse(
                description: 'Client Created Response'
            ),
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new CreateCommand(
                $uuid,
                $request->get('email') ?? '',
                $request->get('first_name') ?? '',
                $request->get('last_name') ?? '',
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }

    #[OA\Get(
        path: '/clients/{uuid}',
        summary: 'Show a client',
        tags: ['Clients'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OA\Parameter(
                in: 'path',
                name: 'uuid',
                example: 'aabe3af0-4348-4492-bbae-ac4e40c83ef8',
                required: true
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: 'Client show response',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(ref: '#/components/schemas/Admin:Client:ShowRequestBodySchema')
                )
            ),
        ]
    )]
    public function show(string $uuid): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                new ShowQuery($uuid)
            )
        );
    }

    #[OA\Put(
        path: '/clients/{uuid}',
        summary: 'Update a client',
        tags: ['Clients'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OA\Parameter(
                in: 'path',
                name: 'uuid',
                example: 'aabe3af0-4348-4492-bbae-ac4e40c83ef8',
                required: true
            ),
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: '#/components/schemas/Admin:Client:UpdateRequestBodySchema',
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: 'Client updated',
                content: new OA\MediaType(
                    mediaType: 'application/json'
                )
            ),
        ]
    )]
    public function update(Request $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->get('email') ?? '',
                $request->get('first_name') ?? '',
                $request->get('last_name') ?? '',
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    #[OA\Delete(
        path: '/clients/{uuid}',
        summary: 'Update a client',
        tags: ['Clients'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OA\Parameter(
                in: 'path',
                name: 'uuid',
                example: 'aabe3af0-4348-4492-bbae-ac4e40c83ef8',
                required: true
            ),
        ],
        responses: [
            new OAC\Responses\CreatedResponse(description: 'Client deleted response'),
        ]
    )]
    public function destroy(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new DeleteCommand($uuid)
        );

        return $this->response->noContent();
    }
}