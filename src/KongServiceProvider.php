<?php

namespace DouglasDC3\Kong;

use DouglasDC3\Kong\Http\HttpClient;
use Illuminate\Contracts\Foundation\Application;
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

        $this->app->bind(HttpClient::class, function () {
            return new HttpClient(
                config('kong.base_uri'),
                [
                    'query' => config('kong.query', []),
                    'headers' => config('kong.headers', [])
                ]
            );
        });

        $this->app->singleton(Kong::class, function (Application $app) {
            return new Kong($app->make(HttpClient::class));
        });
    }
}
