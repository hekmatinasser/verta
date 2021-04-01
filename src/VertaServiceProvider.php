<?php

namespace Hekmatinasser\Verta;

use Hekmatinasser\Verta\Verta;
use Illuminate\Support\ServiceProvider;
use Hekmatinasser\Verta\Validation\ValidatorLoader;

class VertaServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        ValidatorLoader::loadValidators();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('verta', function ($app) {
            return new Verta;
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('verta');
    }
}
