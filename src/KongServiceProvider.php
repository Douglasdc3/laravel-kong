<?php

namespace DouglasDC3\Kong;

use DouglasDC3\Kong\Http\HttpClient;
use Illuminate\Support\ServiceProvider;

class KongServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/kong.php' => config_path('kong.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/kong.php', 'kong');

        $this->app->singleton(Kong::class, function ($app) {
            return new Kong(new HttpClient(
                config('kong.base_uri'),
                [
                    'query' => config('kong.query', []),
                    'headers' => config('kong.headers', [])
                ]
            ));
        });
    }
}
