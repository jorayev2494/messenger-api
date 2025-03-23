<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Client\Profile\Presentation\Http\API\REST\Controllers\ProfileController;

Route::group(
    ['prefix' => 'profile', 'controller' => ProfileController::class],
    static function (Router $router): void {
        $router->get('/', 'show');
    }
);
