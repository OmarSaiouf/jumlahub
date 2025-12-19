<?php

namespace App\Providers;


use App\Core\Services\PaymentProviderService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->singleton('payment.provider.service', PaymentProviderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
       
    }

   


}
