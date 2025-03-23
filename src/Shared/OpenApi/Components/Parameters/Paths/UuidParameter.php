<?php

declare(strict_types=1);

namespace Project\Shared\OpenApi\Components\Parameters\Paths;

use OpenApi\Attributes as OA;
use OpenApi\Generator;

class UuidParameter extends OA\Parameter
{
    public function __construct(
        ?string $parameter = null,
        ?string $name = null,
        ?string $description = null,
        ?string $in = null,
        ?bool $required = true,
        ?bool $deprecated = null,
        ?bool $allowEmptyValue = null,
        string|object|null $ref = null,
        ?OA\Schema $schema = null,
        ?string $example = null,
        ?array $examples = null,
        array|OA\JsonContent|OA\XmlContent|OA\Attachable|null $content = null,
        ?string $style = null,
        ?bool $explode = null,
        ?bool $allowReserved = null,
        ?array $spaceDelimited = null,
        ?array $pipeDelimited = null,
        // annotation
        ?array $x = null,
        ?array $attachables = null
    ) {
        parent::__construct(
            parameter: $parameter ?? Generator::UNDEFINED,
            name: $name ?? 'uuid',
            description: $description ?? Generator::UNDEFINED,
            in: $in ?? 'path',
            required: $required ?? true,
            deprecated: $deprecated ?? false,
            allowEmptyValue: $allowEmptyValue ?? false,
            ref: $ref ?? Generator::UNDEFINED,
            example: $example ?? 'aabe3af0-4348-4492-bbae-ac4e40c83ef8',
            style: $style ?? Generator::UNDEFINED,
            explode: $explode ?? false,
            allowReserved: $allowReserved ?? false,
            spaceDelimited: $spaceDelimited ?? [],
            pipeDelimited: $pipeDelimited ?? [],
            x: $x ?? [],
        );
    }
}