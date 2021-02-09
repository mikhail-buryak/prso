<?php

namespace App\Providers;

use App\Services\Sign\Sign;
use App\Services\Tax\Command;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Command::class, function ($app) {
            return new Command(config('tax'), app(Sign::class));
        });
    }
}