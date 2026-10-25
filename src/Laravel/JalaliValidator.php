<?php

namespace Hekmatinasser\Verta\Laravel;

use Exception;
use Hekmatinasser\Verta\Verta;

class JalaliValidator
{
    private const DEFAULT_DATE_FORMAT = 'Y/m/d';
    private const DEFAULT_DATETIME_FORMAT = 'Y/m/d H:i:s';

    /**
     * Determines if an input is a valid Jalali date with the specified format
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDate(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeValue($value, $parameters, self::DEFAULT_DATE_FORMAT);
    }

    /**
     * Determines if an input is a valid Jalali date with the specified format and
     * it is equal a given date
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateEqual(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison($value, $parameters, self::DEFAULT_DATE_FORMAT, 'eq');
    }

    /**
     * Determines if an input is a valid Jalali date with the specified format and
     * it is not equal a given date
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateNotEqual(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison($value, $parameters, self::DEFAULT_DATE_FORMAT, 'ne');
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTime(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeValue($value, $parameters, self::DEFAULT_DATETIME_FORMAT);
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is equal a given datetime
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTimeEqual(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison($value, $parameters, self::DEFAULT_DATETIME_FORMAT, 'eq');
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is not equal a given datetime
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTimeNotEqual(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison($value, $parameters, self::DEFAULT_DATETIME_FORMAT, 'ne');
    }

    /**
     * Determines if an input is a valid Jalali date with the specified format and
     * it is after a given date
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateAfter(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison($value, $parameters, self::DEFAULT_DATE_FORMAT, 'gt');
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is after or equal a given datetime
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateAfterEqual(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison($value, $parameters, self::DEFAULT_DATE_FORMAT, 'gte');
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is after a given datetime
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTimeAfter(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison($value, $parameters, self::DEFAULT_DATETIME_FORMAT, 'gt');
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is after or equal a given datetime
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTimeAfterEqual(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison($value, $parameters, self::DEFAULT_DATETIME_FORMAT, 'gte');
    }

    /**
     * Determines if an input is a valid Jalali date with the specified format and
     * it is before a given date
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateBefore(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison($value, $parameters, self::DEFAULT_DATE_FORMAT, 'lt');
    }

    /**
     * Determines if an input is a valid Jalali date with the specified format and
     * it is before or equal a given date
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateBeforeEqual(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison($value, $parameters, self::DEFAULT_DATE_FORMAT, 'lte');
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is before a given date-time
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTimeBefore(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison($value, $parameters, self::DEFAULT_DATETIME_FORMAT, 'lt');
    }

    /**
     * Determines if an input is a valid Jalali datetime with the specified format and
     * it is before or equal a given datetime
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDateTimeBeforeEqual(string $attribute, mixed $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison($value, $parameters, self::DEFAULT_DATETIME_FORMAT, 'lte');
    }

    /**
     * replace date or datetime
     * @param string $message
     * @param string $attribute
     * @param string $rule
     * @param array $parameters
     * @return string
     */
    public function replaceDateOrDatetime(string $message, string $attribute, string $rule, array $parameters): string
    {
        return $message;
    }

    /**
     * replace date after or before or equal
     * @param string $message
     * @param string $attribute
     * @param string $rule
     * @param array $parameters
     * @return string
     */
    public function replaceDateAfterOrBeforeOrEqual(string $message, string $attribute, string $rule, array $parameters): string
    {
        return $this->replaceComparisonDateInMessage($message, $parameters, self::DEFAULT_DATE_FORMAT);
    }

    /**
     * replace date time after or before or equal
     * @param string $message
     * @param string $attribute
     * @param string $rule
     * @param array $parameters
     * @return string
     */
    public function replaceDateTimeAfterOrBeforeOrEqual(string $message, string $attribute, string $rule, array $parameters): string
    {
        return $this->replaceComparisonDateInMessage($message, $parameters, self::DEFAULT_DATETIME_FORMAT);
    }

    private function validateDateTimeValue(mixed $value, array $parameters, string $defaultFormat): bool
    {
        if (! is_string($value)) {
            return false;
        }

        $format = count($parameters) ? $parameters[0] : $defaultFormat;

        try {
            Verta::parseFormat($format, $value);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    private function validateDateTimeComparison(
        mixed $value,
        array $parameters,
        string $defaultFormat,
        string $comparison
    ): bool {
        if (! is_string($value)) {
            return false;
        }

        $format = count($parameters) > 1 ? $parameters[1] : $defaultFormat;

        try {
            // A missing comparison date preserves the comparison methods' "now" default.
            $base = count($parameters) > 0 ? Verta::parseFormat($format, $parameters[0]) : null;

            return Verta::parseFormat($format, $value)->{$comparison}($base);
        } catch (Exception $e) {
            return false;
        }
    }

    private function replaceComparisonDateInMessage(string $message, array $parameters, string $defaultFormat): string
    {
        $format = count($parameters) > 1 ? $parameters[1] : $defaultFormat;
        $date = count($parameters) ? $parameters[0] : Verta::instance()->format($format);
        if (Verta::getLocale() != 'en') {
            $en = Verta::getMessages('en');
            $to = Verta::getMessages();
            $date = str_replace(array_values($en['numbers']), array_values($to['numbers']), $date);
        }

        return str_replace(':date', $date, $message);
    }
}
