<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Client\Presentation\Http\API\REST\Controllers\ClientController;

Route::group(
    ['prefix' => 'clients', 'controller' => ClientController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'destroy');
    }
);
