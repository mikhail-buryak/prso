<?php

namespace App\Providers;

use App\Services\Sign\Sign;
use Illuminate\Support\ServiceProvider;

class SignServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Sign::class, function ($app) {
            return new Sign(config('sign'));
        });
    }
}