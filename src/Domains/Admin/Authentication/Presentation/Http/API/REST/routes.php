<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Authentication\Presentation\Http\API\REST\Controllers\AuthenticationController;

Route::group(
    ['prefix' => 'auth', 'controller' => AuthenticationController::class],
    static function (Router $router): void {
        $router->post('/login', 'login');
        $router->post('/logout', 'logout');
        $router->post('/refresh-token', 'refreshToken');
        $router->post('/restore-password', 'restorePassword');
    }
);
