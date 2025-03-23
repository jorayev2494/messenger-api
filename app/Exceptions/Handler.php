<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Project\Shared\Utils\Response\Contracts\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

readonly class Handler
{
    public static function handle(Exceptions $exceptions): void
    {
        $exceptions->renderable(static function (\Symfony\Component\Validator\Exception\ValidationFailedException $ex, Request $request) {
            if ($request->is('api/*')) {
                $response = resolve(ResponseInterface::class);

                return $response->json([
                    'driver' => 'symfony',
                    ...$ex->getValue(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });

        $exceptions->renderable(static function (\Illuminate\Auth\AuthenticationException $ex, Request $request) {
            if ($request->is('api/*')) {
                $response = resolve(ResponseInterface::class);

                return $response->json([
                    'message' => $ex->getMessage(),
                ], Response::HTTP_UNAUTHORIZED);
            }
        });

        $exceptions->renderable(static function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $ex, Request $request) {
            if ($request->is('api/*')) {
                $response = resolve(ResponseInterface::class);

                return $response->json([
                    'message' => $ex->getMessage(),
                ], Response::HTTP_FORBIDDEN);
            }
        });

        $exceptions->renderable(static function (\Project\Shared\Domain\Exceptions\Contracts\DomainException $ex, Request $request) {
            if ($request->is('api/*')) {
                $response = resolve(ResponseInterface::class);

                return $response->json([
                    'message' => $ex->getMessage(),
                ], $ex->getHttpResponseCode());
            }
        });

        $exceptions->renderable(static function (\Project\Shared\Domain\Exceptions\DomainException $ex, Request $request) {
            if ($request->is('api/*')) {
                $response = resolve(ResponseInterface::class);

                return $response->json([
                    'message' => $ex->getMessage(),
                ], $ex->getHttpResponseCode());
            }
        });

//        $exceptions->renderable(static function (\Illuminate\Validation\ValidationException $ex, Request $request) {
//            if ($request->is('api/*')) {
//                $response = resolve(ResponseInterface::class);
//
//                return $response->json([
//                    'message' => 'Validation failed',
//                    'fails' => $ex->validator->errors(),
//                ], Response::HTTP_UNPROCESSABLE_ENTITY);
//            }
//        });

        $exceptions->renderable(static function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $ex, Request $request) {
            if ($request->is('api/*')) {
                $response = resolve(ResponseInterface::class);

                return $response->json([
                    'message' => $ex->getMessage(),
                ], Response::HTTP_NOT_FOUND);
            }
        });

        $exceptions->renderable(static function (\Symfony\Component\HttpKernel\Exception\BadRequestHttpException $ex, Request $request) {
            if ($request->is('api/*')) {
                $response = resolve(ResponseInterface::class);

                return $response->json([
                    'message' => $ex->getPrevious()?->getMessage() ?? $ex->getMessage(),
                ], Response::HTTP_BAD_REQUEST);
            }
        });

        $exceptions->renderable(static function (\Exception $ex, Request $request) {
            if ($request->is('api/*')) {
                $response = resolve(ResponseInterface::class);

                return $response->json([
                    'message' => $ex->getMessage(),
                    'file' => $ex->getFile(),
                    'line' => $ex->getLine(),
                    'previous' => $ex->getPrevious(),
                ], Response::HTTP_BAD_REQUEST);
            }
        });

        $exceptions->renderable(static function (\Throwable $ex, Request $request) {
            if ($request->is('api/*')) {
                $response = resolve(ResponseInterface::class);

                return $response->json([
                    'message' => $ex->getMessage(),
                    'file' => $ex->getFile(),
                    'line' => $ex->getLine(),
                    'previous' => $ex->getPrevious(),
                ], Response::HTTP_BAD_REQUEST);
            }
        });
    }
}
