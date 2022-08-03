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
            $params = [
                'createPath' => config('magento.create_path'),
                'loginPath' => config('magento.login_path'),
                'bodyLogin' => [
                    'username' => config('magento.username'),
                    'password' => config('magento.password'),
                ],
            ];
            return new MagentoClient(
                new Client(
                    [
                        'base_uri' => config('magento.base_uri'),
                        'allow_redirects' => false,
                    ]
                ),
                $params
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
