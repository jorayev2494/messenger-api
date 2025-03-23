<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Presentation\Http\API\REST\Controllers;

use OpenApi\Attributes as OA;

#[
    OA\Info(version: '1.0.0', description: 'Delivery', title: 'Mobile documentation for Delivery'),
    OA\Server(url: 'http://127.0.0.1:8088/api/client', description: 'Local server 8088'),
//    OA\Server(url: 'http://127.0.0.1:8000/api/mobile/v1', description: 'Local server'),
//    OA\Server(url: 'https://216.250.13.195:443/api/mobile/v1', description: 'Staging server'),
//    OA\Server(url: 'https://alsat.com.tm/api/mobile/v1', description: 'Prod domain'),
    OA\SecurityScheme(securityScheme: 'authBearerToken', type: 'http', name: 'Authorization', in: 'header', scheme: 'bearer'),
    # OA\SecurityScheme(securityScheme: 'bearerAuth', type: 'http', name: 'Authorization', in: 'header', scheme: 'bearer'),
    OA\Tag(name: 'default', description: 'Default'),
    OA\Tag(name: 'Authentication', description: 'Authentication'),
    OA\Tag(name: 'Code', description: 'Code'),
    OA\Tag(name: 'Profile', description: 'Profile'),
]
class BaseController
{

}