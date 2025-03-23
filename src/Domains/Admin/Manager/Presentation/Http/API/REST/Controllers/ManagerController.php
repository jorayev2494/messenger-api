<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Presentation\Http\API\REST\Controllers;

use Illuminate\Http\Request;
use Project\Domains\Admin\Manager\Application\Manager\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Manager\Application\Manager\Commands\Create\Command as CreateCommand;
use Project\Domains\Admin\Manager\Application\Manager\Queries\Show\Query as ShowQuery;
use Project\Domains\Admin\Manager\Application\Manager\Commands\Update\Command as UpdateCommand;
use Project\Domains\Admin\Manager\Application\Manager\Commands\Delete\Command as DeleteCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;
use Project\Shared\OpenApi\Components as OAC;
use Symfony\Component\HttpFoundation\Response;

readonly class ManagerController
{
    public function __construct(
        private ResponseInterface $response,
        private UuidGeneratorInterface $uuidGenerator,
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    ) { }

    #[OA\Get(
        path: '/managers',
        summary: 'Manager paginate',
        tags: ['Managers'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OAC\Parameters\Queries\PageParameter(),
            new OAC\Parameters\Queries\PerPageParameter(),
        ],
        responses: [
            new OAC\Responses\PaginateResponse(
                dataRef: '#/components/schemas/Admin:Manager:IndexResponseSchema'
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
        path: '/managers',
        summary: 'Create a manager',
        tags: ['Managers'],
        security: [
            ['authBearerToken' => []],
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: '#/components/schemas/Admin:Manager:CreateRequestBodySchema',
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: 'Manager created',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(
                                type: 'string',
                                property: 'uuid',
                                example: 'aabe3af0-4348-4492-bbae-ac4e40c83ef8',
                                uniqueItems: true
                            ),
                        ]
                    )
                )
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

        return $this->response->json(['uuid' => $uuid]);
    }

    #[OA\Get(
        path: '/managers/{uuid}',
        summary: 'Show a manager',
        tags: ['Managers'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OAC\Parameters\Paths\UuidParameter(),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: 'Manager created',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(ref: '#/components/schemas/Admin:Manager:ShowRequestBodySchema')
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
        path: '/managers/{uuid}',
        summary: 'Update a manager',
        tags: ['Managers'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OAC\Parameters\Paths\UuidParameter(),
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: '#/components/schemas/Admin:Manager:UpdateRequestBodySchema',
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: 'Manager created',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(
                                type: 'string',
                                property: 'uuid',
                                example: 'aabe3af0-4348-4492-bbae-ac4e40c83ef8'
                            ),
                        ]
                    )
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
        path: '/managers/{uuid}',
        summary: 'Update a manager',
        tags: ['Managers'],
        security: [
            ['authBearerToken' => []],
        ],
        parameters: [
            new OAC\Parameters\Paths\UuidParameter(),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_NO_CONTENT,
                description: 'Manager deleted',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                )
            ),
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