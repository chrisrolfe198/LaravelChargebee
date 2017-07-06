<?php

namespace ThatChrisR\LaravelChargebee;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
    }
}
