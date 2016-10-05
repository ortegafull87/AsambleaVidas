<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {/*
        $this->app->bind(
            'App\Service\UserService',
            'App\Service\UserServiceImpl',
            'App\Dao\UserDao',
            'App\Dao\UserDaoImpl'
        );*/
    }
}
