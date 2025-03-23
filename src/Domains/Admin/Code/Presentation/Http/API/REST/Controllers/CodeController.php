<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Code\Presentation\Http\API\REST\Controllers;

use Illuminate\Http\Request;
use Project\Domains\Admin\Code\Application\Code\Commands\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

readonly class CodeController
{
    public function __construct(
        private ResponseInterface $response,
        private CommandBusInterface $commandBus
    ) { }

    #[OA\Post(
        path: '/codes',
        summary: 'Generate code',
        tags: ['Code'],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            type: 'string',
                            property: 'email',
                            example: 'admin@gmail.com'
                        ),
                        new OA\Property(
                            type: 'string',
                            property: 'type',
                            ref: '#/components/schemas/Admin:Code:Type',
                        )
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: 'Response description',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                )
            ),
        ]
    )]
    public function __invoke(Request $request): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $request->get('email') ?? '',
                $request->get('type') ?? ''
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}