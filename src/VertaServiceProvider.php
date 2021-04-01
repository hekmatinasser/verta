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

    const REPLACERS = [
        'jdate' => 'replaceDateOrDatetime',
        'jdate_equal' => 'replaceDateAfterOrBeforeOrEqual',
        'jdate_not_equal' => 'replaceDateAfterOrBeforeOrEqual',
        'jdatetime' => 'replaceDateOrDatetime',
        'jdatetime_equal' => 'replaceDateTimeAfterOrBeforeOrEqual',
        'jdatetime_not_equal' => 'replaceDateTimeAfterOrBeforeOrEqual',
        'jdate_after' => 'replaceDateAfterOrBeforeOrEqual',
        'jdate_after_equal' => 'replaceDateAfterOrBeforeOrEqual',
        'jdatetime_after' => 'replaceDateTimeAfterOrBeforeOrEqual',
        'jdatetime_after_equal' => 'replaceDateTimeAfterOrBeforeOrEqual',
        'jdate_before' => 'replaceDateAfterOrBeforeOrEqual',
        'jdate_before_equal' => 'replaceDateAfterOrBeforeOrEqual',
        'jdatetime_before' => 'replaceDateTimeAfterOrBeforeOrEqual',
        'jdatetime_before_equal' => 'replaceDateTimeAfterOrBeforeOrEqual',
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

        foreach (self::REPLACERS as $name => $method) {
            Validator::replacer($name, JalaliValidator::class . '@' . $method);
        }
    }
}
