<?php

namespace App\Providers;

use App\Utils\Uploader;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('uploader', Uploader::class);
        $this->app->singleton('captcha', CaptchaBuilder::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
