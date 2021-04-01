<?php

namespace Hekmatinasser\Verta;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class VertaServiceProvider extends ServiceProvider
{
    const DATE_VALIDATORS = [
        'jdate' => 'validateDate',
        'jdate_equal' => 'validateDateEqual',
        'jdate_not_equal' => 'validateDateNotEqual',
        'jdatetime' => 'validateDateTime',
        'jdatetime_equal' => 'validateDateTimeEqual',
        'jdatetime_not_equal' => 'validateDateTimeNotEqual',
        'jdate_after' => 'validateDateAfter',
        'jdate_after_equal' => 'validateDateAfterEqual',
        'jdatetime_after' => 'validateDateTimeAfter',
        'jdatetime_after_equal' => 'validateDateTimeAfterEqual',
        'jdate_before' => 'validateDateBefore',
        'jdate_before_equal' => 'validateDateBeforeEqual',
        'jdatetime_before' => 'validateDateTimeBefore',
        'jdatetime_before_equal' => 'validateDateTimeBeforeEqual'
    ];

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
        foreach (self::DATE_VALIDATORS as $name => $method) {
            Validator::extend($name, JalaliValidator::class . '@' . $method);
        }

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
