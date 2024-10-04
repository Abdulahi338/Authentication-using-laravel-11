<?php
protected $routeMiddleware = [
    // Other middleware...
    'check.user.verify' => \App\Http\Middleware\CheckUserAndVerify::class,
];
