<?php

namespace App\Providers;

use App\Services\Sign\Sign;
use App\Services\Tax\Document;
use Illuminate\Support\ServiceProvider;

class DocumentServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Document::class, function ($app) {
            return new Document(config('tax'), app(Sign::class));
        });
    }
}