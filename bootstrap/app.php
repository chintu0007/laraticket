<?php

use App\Providers\TicketServiceProvider;
use App\Providers\UserServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    // ->withAuthorization(function ($gate) {
    //     $gate->policy(Ticket::class, TicketPolicy::class); // Register the policy
    // })
    ->withProviders([TicketServiceProvider::class, UserServiceProvider::class]) // Register custom PolicyServiceProvider
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: [
            __DIR__ . '/../routes/api.php',
            __DIR__ . '/../routes/V1/api_v1.php', // Custom API v1 routes
            __DIR__ . '/../routes/V2/api_v2.php', // Custom API v2 routes
        ],
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
