<?php

declare(strict_types=1);

namespace Project\Shared\Utils\Response;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Utils\Response\Contracts\HttpResponseInterface;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Illuminate\Http\JsonResponse;

readonly class Response implements ResponseInterface
{
    public function __construct(
        private ResponseFactory $response
    ) { }

    public function json(mixed $data = [], $status = 200, array $headers = [], $options = 0): JsonResponse
    {
        if ($data instanceof ArrayableInterface) {
            $data = $data->toArray();
        }

        if ($data instanceof HttpResponseInterface) {
            $data = $data->toHttpResponse();
        }

        return $this->response->json($data, $status, $headers, $options);
    }

    public function noContent($status = 204, array $headers = []): \Illuminate\Http\Response
    {
        return $this->response->noContent($status, $headers);
    }
}