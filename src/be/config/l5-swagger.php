<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Swagger Documentation
    |--------------------------------------------------------------------------
    */

    'enabled' => env('L5_SWAGGER_ENABLED', true),

    'ui' => env('L5_SWAGGER_UI', 'swagger-ui'),

    'route' => [
        'prefix' => 'api',
        'name' => 'l5-swagger',
        'domain' => null,
        'sortEndpoints' => env('L5_SWAGGER_SORT_ENDPOINTS', true),
        'middleware' => [],
    ],

    'annotations' => [
        base_path('routes'),
        base_path('app'),
    ],

    'path' => base_path('docs/api'),

    'security_definitions' => [
        'Bearer' => [
            'type' => 'apiKey',
            'name' => 'Authorization',
            'in' => 'header',
        ],
    ],

    'info' => [
        'title' => env('APP_NAME', 'MagicPort API'),
        'description' => 'MagicPort Laravel backend API — company, project, task, user management with Sanctum auth and RBAC.',
        'version' => '1.0.0',
        'contact' => [
            'email' => 'support@magicport.example',
        ],
        'license' => [
            'name' => 'MIT',
            'url' => 'https://opensource.org/licenses/MIT',
        ],
    ],

    'schemes' => [env('L5_SWAGGER_SCHEMES', 'http')],

    'host' => env('L5_SWAGGER_HOST', 'localhost'),

    'base_path' => '/api/v1',

    'consumes' => ['application/json'],

    'produces' => ['application/json'],

];
