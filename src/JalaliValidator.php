<?php

namespace Hekmatinasser\Verta;


class JalaliValidator
{
    public function validateDate($attribute, $value, $parameters)
    {
        if (!is_string($value)) {
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

    public function validateDateTime($attribute, $value, $parameters)
    {
        if (!is_string($value)) {
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

    public function validateDateAfter($attribute, $value, $parameters)
    {
        if (!is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d';
        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;
            return Verta::parseFormat($format, $value)->greaterThan($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function validateDateTimeAfter($attribute, $value, $parameters)
    {
        if (!is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d H:i:s';
        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;
            return Verta::parseFormat($format, $value)->greaterThan($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function validateDateBefore($attribute, $value, $parameters)
    {
        if (!is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d';
        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;
            return Verta::parseFormat($format, $value)->lessThan($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function validateDateTimeBefore($attribute, $value, $parameters)
    {
        if (!is_string($value)) {
            return false;
        }
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d H:i:s';
        try {
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;
            return Verta::parseFormat($format, $value)->lessThan($base);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function replaceDate($message, $attribute, $rule, $parameters)
    {
        return $message;
    }

    public function replaceDatetime($message, $attribute, $rule, $parameters)
    {
        return $message;
    }

    public function replaceDateAfterOrBefore($message, $attribute, $rule, $parameters)
    {
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d';
        $date = count($parameters) ? $parameters[0] : Verta::instance()->format($format);
        $faDate = Verta::persianNumbers($date);
        return str_replace([':date', ':fa-date'], [$date, $faDate], $message);
    }

    public function replaceDateTimeAfterOrBefore($message, $attribute, $rule, $parameters)
    {
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d H:i:s';
        $date = count($parameters) ? $parameters[0] : Verta::instance()->format($format);
        $faDate = Verta::persianNumbers($date);
        return str_replace([':date', ':fa-date'], [$date, $faDate], $message);
    }
}