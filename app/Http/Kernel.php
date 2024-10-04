<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Global middleware
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'auth.custom' => \App\Http\Middleware\EnsureAuthenticated::class,
        // Other middleware...
    ];

    protected $middlewareGroups = [
        'web' => [
            // Web middleware group
        ],
        'api' => [
            // API middleware group
        ],
    ];
}
