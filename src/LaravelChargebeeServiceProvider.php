<?php

namespace ThatChrisR\LaravelChargebee;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use ChargeBee_Environment;

class LaravelChargebeeServiceProvider extends ServiceProvider
{
    protected $listen = [
        'ThatChrisR\LaravelChargebee\Events\ChargebeePlanCreating' => [
            'ThatChrisR\LaravelChargebee\Listeners\CreatingPlanInChargebee'
        ]
    ];

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/chargebee.php' => config_path('chargebee.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/models/' => app_path()
        ], 'models');

        $this->loadMigrationsFrom(__DIR__.'/../migrations/');

        ChargeBee_Environment::configure(config('chargebee.site'), config('chargebee.api_key'));
    }
}
