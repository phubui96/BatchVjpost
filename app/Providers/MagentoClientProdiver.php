<?php

namespace App\Providers;

use App\Services\Magento\MagentoClient;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class MagentoClientProdiver extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(MagentoClient::class, function () {
            return new MagentoClient(
                new Client(
                    [
                        'base_uri' => config('magento.base_uri'),
                        'allow_redirects' => false,
                    ]
                )
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
