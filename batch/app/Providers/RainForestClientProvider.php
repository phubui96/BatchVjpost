<?php

namespace App\Providers;

use App\Services\RainForest\RainForestClient;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class RainForestClientProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(RainForestClient::class, function () {
            return new RainForestClient(
                new Client(
                    [
                        'base_uri' => config('rainforestapi.base_uri'),
                        'allow_redirects' => false,
                    ]
                ),
                [
                    'api_key' => config('rainforestapi.api_key'),
                    'amazon_domain' => config('rainforestapi.domain'),
                ]
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
