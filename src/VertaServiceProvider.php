<?php

namespace Hekmatinasser\Verta;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class VertaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->validator();
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

    protected function validator()
    {
        Validator::extend('jdate', JalaliValidator::class . '@validateDate');
        Validator::extend('jdatetime', JalaliValidator::class . '@validateDateTime');
        Validator::extend('jdate_after', JalaliValidator::class . '@validateDateAfter');
        Validator::extend('jdatetime_after', JalaliValidator::class . '@validateDateTimeAfter');
        Validator::extend('jdate_before', JalaliValidator::class . '@validateDateBefore');
        Validator::extend('jdatetime_before', JalaliValidator::class . '@validateDateTimeBefore');

        Validator::replacer('jdate', JalaliValidator::class . '@replaceDate');
        Validator::replacer('jdatetime', JalaliValidator::class . '@replaceDateTime');
        Validator::replacer('jdate_after', JalaliValidator::class . '@replaceDateAfterOrBefore');
        Validator::replacer('jdatetime_after', JalaliValidator::class . '@replaceDateTimeAfterOrBefore');
        Validator::replacer('jdate_before', JalaliValidator::class . '@replaceDateAfterOrBefore');
        Validator::replacer('jdatetime_before', JalaliValidator::class . '@replaceDateTimeAfterOrBefore');
    }
}
