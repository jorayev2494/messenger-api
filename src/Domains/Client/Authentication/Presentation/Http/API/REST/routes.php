<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Client\Authentication\Presentation\Http\API\REST\Controllers\AuthenticationController;

Route::group(
    ['prefix' => 'auth', 'controller' => AuthenticationController::class],
    static function (Router $router): void {
        $router->post('/login', 'login');
        $router->post('/register', 'register');
        $router->post('/refresh-token', 'refreshToken');
        $router->post('/logout', 'logout');
        $router->post('/restore-password', 'restorePassword');
    }
);
