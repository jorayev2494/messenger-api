<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Project\Infrastructure\Services\Authentication\Auth;
use Project\Infrastructure\Services\WS\Contracts\WSServiceInterface;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PingPongController extends Controller
{
    public function __construct(
        private readonly ResponseInterface $response,
        private readonly WSServiceInterface $WSService
    ) { }

    public function generateToken(): JsonResponse
    {
        $member = Auth::manager();

        return $this->response->json([
            'token' => $this->WSService->generateConnectionToken($member, [
                'uuid' => $member->getUuid()->value,
                'email' => $member->getEmail()->value,
            ]),
        ]);
    }

    public function wsHealth(): Response
    {
        $this->WSService->publish(
            'health',
            [
                'message' => 'Check health',
                'key' => 'value',
                'time' => time(),
            ]
        );

        return $this->response->noContent();
    }
}
