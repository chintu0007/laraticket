<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\Ticket;
use App\Policies\V1\TicketPolicy;
use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::policy(Ticket::class, TicketPolicy::class);
    }
}
