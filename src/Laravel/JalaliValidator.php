<?php

namespace Hekmatinasser\Verta\Laravel;

use Hekmatinasser\Verta\Verta;

class JalaliValidator
{
    /**
     * Determines if an input is a valid Jalali date with the specified format
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDate($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) ? $parameters[0] : 'Y/m/d';

        try {
            Verta::parseFormat($format, $value);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Determines if an input is a valid Jalali date with the specified format and
     * it is equal a given date
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateEqual($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d';

        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->eq($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Determines if an input is a valid Jalali date with the specified format and
     * it is not equal a given date
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateNotEqual($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d';

        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->ne($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTime($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }

        $format = count($parameters) ? $parameters[0] : 'Y/m/d H:i:s';

        try {
            Verta::parseFormat($format, $value);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is equal a given datetime
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTimeEqual($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d H:i:s';

        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->eq($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is not equal a given datetime
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTimeNotEqual($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d H:i:s';

        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->ne($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Determines if an input is a valid Jalali date with the specified format and
     * it is after a given date
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateAfter($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d';

        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->gt($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is after or equal a given datetime
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateAfterEqual($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d';

        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->gte($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is after a given datetime
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTimeAfter($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d H:i:s';

        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->gt($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is after or equal a given datetime
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTimeAfterEqual($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d H:i:s';

        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->gte($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Determines if an input is a valid Jalali date with the specified format and
     * it is before a given date
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateBefore($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d';

        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->lt($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Determines if an input is a valid Jalali date with the specified format and
     * it is before or equal a given date
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateBeforeEqual($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d';

        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->lte($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is before a given date-time
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTimeBefore($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d H:i:s';

        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->lt($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is before or equal a given datetime
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTimeBeforeEqual($attribute, $value, $parameters)
    {
        if (! is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d H:i:s';

        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->lte($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * replace date or datetime
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function replaceDateOrDatetime($message, $attribute, $rule, $parameters)
    {
        return $message;
    }

    /**
     * replace date after or before or equal
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function replaceDateAfterOrBeforeOrEqual($message, $attribute, $rule, $parameters)
    {
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d';
        $date = count($parameters) ? $parameters[0] : Verta::instance()->format($format);
        if (Verta::getLocale() != 'en') {
            $en = Verta::getMessages('en');
            $to = Verta::getMessages();
            $date = str_replace(array_values($en['numbers']), array_values($to['numbers']), $date);
        }

        return str_replace(':date', $date, $message);
    }

    /**
     * replace date time after or before or equal
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function replaceDateTimeAfterOrBeforeOrEqual($message, $attribute, $rule, $parameters)
    {
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d H:i:s';
        $date = count($parameters) ? $parameters[0] : Verta::instance()->format($format);
        if (Verta::getLocale() != 'en') {
            $en = Verta::getMessages('en');
            $to = Verta::getMessages();
            $date = str_replace(array_values($en['numbers']), array_values($to['numbers']), $date);
        }

        return str_replace(':date', $date, $message);
    }
}
