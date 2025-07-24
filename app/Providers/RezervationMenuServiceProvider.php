<?php

namespace App\Providers;

use App\Business\Abstract\IRezervationService;
use App\Http\Controllers\RezervationMenusController;
use Illuminate\Support\ServiceProvider;

class RezervationMenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->resolving(RezervationMenusController::class, function ($controller, $app) {
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
