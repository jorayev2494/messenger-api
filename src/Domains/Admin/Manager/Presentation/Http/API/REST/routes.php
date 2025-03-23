<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Manager\Presentation\Http\API\REST\Controllers\ManagerController;

Route::group(
    ['prefix' => 'managers', 'controller' => ManagerController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'destroy');
    }
);
