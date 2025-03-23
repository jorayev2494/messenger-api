<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Role\Presentation\Http\API\REST\Controllers\RoleController;
use Project\Domains\Admin\Role\Presentation\Http\API\REST\Controllers\PermissionController;
use Project\Domains\Admin\Role\Presentation\Http\API\REST\Controllers\MemberController;

Route::group(
    ['prefix' => 'roles', 'controller' => RoleController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'destroy');
        $router->post('/{uuid}/permissions', [RoleController::class, 'changePermissions']);

        $router->get('/members/{member_uuid}', [MemberController::class, 'getRole']);
        $router->put('/{uuid}/members/{member_uuid}', [MemberController::class, 'setToMember']);

        $router->group(
            ['prefix' => 'permissions', 'controller' => PermissionController::class],
            static function (Router $router): void {
                $router->get('/', 'list');
                $router->post('/', 'create');
            }
        );
    }
);
