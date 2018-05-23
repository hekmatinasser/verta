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
        Validator::extend('jdate_equal', JalaliValidator::class . '@validateDateEqual');
        Validator::extend('jdate_not_equal', JalaliValidator::class . '@validateDateNotEqual');
        Validator::extend('jdatetime', JalaliValidator::class . '@validateDateTime');
        Validator::extend('jdatetime_equal', JalaliValidator::class . '@validateDateTimeEqual');
        Validator::extend('jdatetime_not_equal', JalaliValidator::class . '@validateDateTimeNotEqual');
        Validator::extend('jdate_after', JalaliValidator::class . '@validateDateAfter');
        Validator::extend('jdate_after_equal', JalaliValidator::class . '@validateDateAfterEqual');
        Validator::extend('jdatetime_after', JalaliValidator::class . '@validateDateTimeAfter');
        Validator::extend('jdatetime_after_equal', JalaliValidator::class . '@validateDateTimeAfterEqual');
        Validator::extend('jdate_before', JalaliValidator::class . '@validateDateBefore');
        Validator::extend('jdate_before_equal', JalaliValidator::class . '@validateDateBeforeEqual');
        Validator::extend('jdatetime_before', JalaliValidator::class . '@validateDateTimeBefore');
        Validator::extend('jdatetime_before_equal', JalaliValidator::class . '@validateDateTimeBeforeEqual');

        Validator::replacer('jdate', JalaliValidator::class . '@replaceDateOrDatetime');
        Validator::replacer('jdate_equal', JalaliValidator::class . '@replaceDateAfterOrBeforeOrEqual');
        Validator::replacer('jdate_not_equal', JalaliValidator::class . '@replaceDateAfterOrBeforeOrEqual');
        Validator::replacer('jdatetime', JalaliValidator::class . '@replaceDateOrDatetime');
        Validator::replacer('jdatetime_equal', JalaliValidator::class . '@replaceDateTimeAfterOrBeforeOrEqual');
        Validator::replacer('jdatetime_not_equal', JalaliValidator::class . '@replaceDateTimeAfterOrBeforeOrEqual');
        Validator::replacer('jdate_after', JalaliValidator::class . '@replaceDateAfterOrBeforeOrEqual');
        Validator::replacer('jdate_after_equal', JalaliValidator::class . '@replaceDateAfterOrBeforeOrEqual');
        Validator::replacer('jdatetime_after', JalaliValidator::class . '@replaceDateTimeAfterOrBeforeOrEqual');
        Validator::replacer('jdatetime_after_equal', JalaliValidator::class . '@replaceDateTimeAfterOrBeforeOrEqual');
        Validator::replacer('jdate_before', JalaliValidator::class . '@replaceDateAfterOrBeforeOrEqual');
        Validator::replacer('jdate_before_equal', JalaliValidator::class . '@replaceDateAfterOrBeforeOrEqual');
        Validator::replacer('jdatetime_before', JalaliValidator::class . '@replaceDateTimeAfterOrBeforeOrEqual');
        Validator::replacer('jdatetime_before_equal', JalaliValidator::class . '@replaceDateTimeAfterOrBeforeOrEqual');
    }
}
