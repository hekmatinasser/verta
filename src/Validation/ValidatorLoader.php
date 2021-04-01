<?php

namespace Hekmatinasser\Verta\Validation;

use Illuminate\Support\Facades\Validator;

class ValidatorLoader
{
    const EXTEND_INDEX = 0;

    const REPLACER_INDEX = 1;

    const DATE_VALIDATORS = [
        'jdate' => ['validateDate', 'replaceDateOrDatetime'],
        'jdate_equal' => ['validateDateEqual', 'replaceDateAfterOrBeforeOrEqual'],
        'jdate_not_equal' => ['validateDateNotEqual', 'replaceDateAfterOrBeforeOrEqual'],
        'jdatetime' => ['validateDateTime', 'replaceDateOrDatetime'],
        'jdatetime_equal' => ['validateDateTimeEqual', 'replaceDateTimeAfterOrBeforeOrEqual'],
        'jdatetime_not_equal' => ['validateDateTimeNotEqual', 'replaceDateTimeAfterOrBeforeOrEqual'],
        'jdate_after' => ['validateDateAfter', 'replaceDateAfterOrBeforeOrEqual'],
        'jdate_after_equal' => ['validateDateAfterEqual', 'replaceDateAfterOrBeforeOrEqual'],
        'jdatetime_after' => ['validateDateTimeAfter', 'replaceDateTimeAfterOrBeforeOrEqual'],
        'jdatetime_after_equal' => ['validateDateTimeAfterEqual', 'replaceDateTimeAfterOrBeforeOrEqual'],
        'jdate_before' => ['validateDateBefore', 'replaceDateAfterOrBeforeOrEqual'],
        'jdate_before_equal' => ['validateDateBeforeEqual', 'replaceDateAfterOrBeforeOrEqual'],
        'jdatetime_before' => ['validateDateTimeBefore', 'replaceDateTimeAfterOrBeforeOrEqual'],
        'jdatetime_before_equal' => ['validateDateTimeBeforeEqual', 'replaceDateTimeAfterOrBeforeOrEqual'],
    ];


    public static function loadValidators()
    {
        $validatorClass = JalaliValidator::class . '@';

        foreach (self::DATE_VALIDATORS as $name => $methods) {

            if (!is_array($methods) || count($methods) < 1) {
                continue;
            }

            Validator::extend($name, $validatorClass . $methods[self::EXTEND_INDEX]);

            if (array_key_exists(self::REPLACER_INDEX, $methods)) {
                Validator::replacer($name, $validatorClass . $methods[self::REPLACER_INDEX]);
            }
        }
    }
}
