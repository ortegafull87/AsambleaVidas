<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Storage;
use League\Flysystem\Filesystem;
use Dropbox\Client as DropboxClient;
//use League\Flysystem\Dropbox\DropboxAdapter;

class DropboxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
