<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

use Project\Domains\Public\Test\Presentation\Http\API\REST\Controllers\TestController;

Route::get('/ping', [TestController::class, 'ping']);
