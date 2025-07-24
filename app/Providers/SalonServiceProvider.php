<?php

namespace App\Providers;

use App\Business\Abstract\IRezervationService;
use App\Http\Controllers\SalonsController;
use Illuminate\Support\ServiceProvider;

class SalonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->resolving(SalonsController::class, function ($controller, $app) {
            $controller->setRezervationService($app->make(IRezervationService::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
