<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Global middleware
    ];

    protected $middlewareGroups = [
        'web' => [
            // Middleware for web routes
        ],

        'api' => [
            // Middleware for API routes
        ],
    ];

    protected $routeMiddleware = [
        // Other middleware...
        'check.user.verify' => \App\Http\Middleware\CheckUserAndVerify::class,
    ];
}


