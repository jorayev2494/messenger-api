<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Institution\Authentication\Presentation\Http\API\REST\Controllers\AuthenticationController;

Route::group(
    ['prefix' => 'auth', 'controller' => AuthenticationController::class],
    static function (Router $router): void {
        $router->get('/login', 'login');
    }
);
