<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('transformKeys', function ($callback) {
            return $this->mapWithKeys(fn($value, $key) => [
                $callback($key) => is_array($value) ? collect($value)->transformKeys($callback) : $value
            ]);
        });

        Str::macro('money', function ($price) {
            return number_format($price, 2, '.', '');
        });
    }
}
