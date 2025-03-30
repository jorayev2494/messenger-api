<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PingPongController;

Route::group([
    'prefix' => 'health'
], static function (\Illuminate\Routing\Router $router): void {
    $router->get('/ws', [PingPongController::class, 'wsHealth']);
});

Route::group([
    'prefix' => '/admin/ws',
    'middleware' => ['auth:manager']
], static function (\Illuminate\Routing\Router $router): void {
    $router->get('/generate-token', [PingPongController::class, 'generateToken']);
});
