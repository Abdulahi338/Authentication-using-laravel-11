<?php

protected $routeMiddleware = [
    // Other middleware...
    'auth.custom' => \App\Http\Middleware\EnsureAuthenticated::class,
];
?""