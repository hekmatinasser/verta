<?php

namespace Hekmatinasser\Verta\Laravel;

use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class VertaServiceProvider extends ServiceProvider
{
    private $rules = [
        'jdate' => [
            'extend' => 'validateDate',
            'replacer' => 'replaceDateOrDatetime',
        ],
        'jdate_multi_format' => [
            'extend' => 'validateDateMultiFormat',
            'replacer' => 'replaceDateOrDatetime',
        ],
        'jdate_equal' => [
            'extend' => 'validateDateEqual',
            'replacer' => 'replaceDateAfterOrBeforeOrEqual',
        ],
        'jdate_not_equal' => [
            'extend' => 'validateDateNotEqual',
            'replacer' => 'replaceDateAfterOrBeforeOrEqual',
        ],
        'jdatetime' => [
            'extend' => 'validateDateTime',
            'replacer' => 'replaceDateOrDatetime',
        ],
        'jdatetime_equal' => [
            'extend' => 'validateDateTimeEqual',
            'replacer' => 'replaceDateTimeAfterOrBeforeOrEqual',
        ],
        'jdatetime_not_equal' => [
            'extend' => 'validateDateTimeNotEqual',
            'replacer' => 'replaceDateTimeAfterOrBeforeOrEqual',
        ],
        'jdate_after' => [
            'extend' => 'validateDateAfter',
            'replacer' => 'replaceDateAfterOrBeforeOrEqual',
        ],
        'jdate_after_equal' => [
            'extend' => 'validateDateAfterEqual',
            'replacer' => 'replaceDateAfterOrBeforeOrEqual',
        ],
        'jdatetime_after' => [
            'extend' => 'validateDateTimeAfter',
            'replacer' => 'replaceDateTimeAfterOrBeforeOrEqual',
        ],
        'jdatetime_after_equal' => [
            'extend' => 'validateDateTimeAfterEqual',
            'replacer' => 'replaceDateTimeAfterOrBeforeOrEqual',
        ],
        'jdate_before' => [
            'extend' => 'validateDateBefore',
            'replacer' => 'replaceDateAfterOrBeforeOrEqual',
        ],
        'jdate_before_equal' => [
            'extend' => 'validateDateBeforeEqual',
            'replacer' => 'replaceDateAfterOrBeforeOrEqual',
        ],
        'jdatetime_before' => [
            'extend' => 'validateDateTimeBefore',
            'replacer' => 'replaceDateTimeAfterOrBeforeOrEqual',
        ],
        'jdatetime_before_equal' => [
            'extend' => 'validateDateTimeBeforeEqual',
            'replacer' => 'replaceDateTimeAfterOrBeforeOrEqual',
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadValidators();

        Carbon::macro('toJalali', function ($timezone = null) {
            return new Verta($this, $timezone);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('verta', function ($app) {
            return new Verta();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['verta'];
    }

    public function loadValidators()
    {
        $className = JalaliValidator::class . '@';

        foreach ($this->rules as $name => $methods) {
            if (array_key_exists('extend', $methods) || array_key_exists('replacer', $methods)) {
                Validator::extend($name, $className . $methods['extend']);
                Validator::replacer($name, $className . $methods['replacer']);
            }
        }
    }
}
