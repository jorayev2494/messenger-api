<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Client\Code\Presentation\Http\API\REST\Controllers\CodeController;

Route::group(['prefix' => 'codes'], static function (Router $router): void {
    $router->post('/', CodeController::class);
});
