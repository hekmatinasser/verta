<?php

namespace Hekmatinasser\Notowo;

use Illuminate\Support\ServiceProvider;

class NotowoServiceProvider extends ServiceProvider
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
        $this->app->bind('notowo', function ($app) {
            return new Notowo;
        });
    }

    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('notowo');
    }
}
