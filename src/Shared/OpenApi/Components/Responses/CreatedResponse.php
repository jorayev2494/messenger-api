<?php

declare(strict_types=1);

namespace Project\Shared\OpenApi\Components\Responses;

use OpenApi\Attributes\Attachable;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\XmlContent;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class CreatedResponse extends OA\Response
{
    public function __construct(
        string|object|null $ref = null,
        int|string|null $status = Response::HTTP_NO_CONTENT,
        ?string $description = 'Deleted response',
        ?array $headers = null,
        MediaType|JsonContent|XmlContent|Attachable|array|null $content = null,
        ?array $links = null,
        // annotation
        ?array $x = null,
        ?array $attachables = null
    )
    {
        parent::__construct(
            ref: $ref,
            response: $status,
            description: $description,
            headers: $headers,
            content: $content ?? new OA\MediaType(
                mediaType: 'application/json'
            ),
            links: $links,
            x: $x,
            attachables: $attachables
        );
    }
}