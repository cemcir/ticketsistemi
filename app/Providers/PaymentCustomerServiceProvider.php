<?php

namespace App\Providers;

use App\Business\Abstract\IPaymentService;
use App\Business\Abstract\IRezervationService;
use App\Http\Controllers\PaymentCustomersController;
use Illuminate\Support\ServiceProvider;

class PaymentCustomerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->resolving(PaymentCustomersController::class, function ($controller, $app) {
            $controller->setRezervationService($app->make(IRezervationService::class));
        });

        $this->app->resolving(PaymentCustomersController::class, function ($controller, $app) {
            $controller->setPaymentService($app->make(IPaymentService::class));
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
