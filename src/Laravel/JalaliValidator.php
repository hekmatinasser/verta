<?php

namespace Hekmatinasser\Verta\Laravel;

use Exception;
use Hekmatinasser\Verta\Verta;

class JalaliValidator
{
    protected const DEFAULT_DATE_FORMAT = 'Y/m/d';
    protected const DEFAULT_DATETIME_FORMAT = 'Y/m/d H:i:s';

    /**
     * Validate Jalali date with specified format
     */
    public function validateDate(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeValue($value, $parameters, self::DEFAULT_DATE_FORMAT);
    }

    /**
     * Validate Jalali date with multiple possible formats
     */
    public function validateDateMultiFormat(string $attribute, string $value, array $parameters): bool
    {
        foreach ($parameters as $format) {
            if ($this->validateDateTimeValue($value, [$format], self::DEFAULT_DATE_FORMAT)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Validate Jalali date equality
     */
    public function validateDateEqual(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison(
            $value, 
            $parameters, 
            self::DEFAULT_DATE_FORMAT, 
            fn($value, $base) => $value->eq($base)
        );
    }

    /**
     * Validate Jalali date inequality
     */
    public function validateDateNotEqual(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison(
            $value, 
            $parameters, 
            self::DEFAULT_DATE_FORMAT, 
            fn($value, $base) => $value->ne($base)
        );
    }

    /**
     * Validate Jalali datetime with specified format
     */
    public function validateDateTime(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeValue($value, $parameters, self::DEFAULT_DATETIME_FORMAT);
    }

    /**
     * Validate Jalali datetime equality
     */
    public function validateDateTimeEqual(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison(
            $value, 
            $parameters, 
            self::DEFAULT_DATETIME_FORMAT, 
            fn($value, $base) => $value->eq($base)
        );
    }

    /**
     * Validate Jalali datetime inequality
     */
    public function validateDateTimeNotEqual(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison(
            $value, 
            $parameters, 
            self::DEFAULT_DATETIME_FORMAT, 
            fn($value, $base) => $value->ne($base)
        );
    }

    /**
     * Validate Jalali date is after
     */
    public function validateDateAfter(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison(
            $value, 
            $parameters, 
            self::DEFAULT_DATE_FORMAT, 
            fn($value, $base) => $value->gt($base)
        );
    }

    /**
     * Validate Jalali date is after or equal
     */
    public function validateDateAfterEqual(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison(
            $value, 
            $parameters, 
            self::DEFAULT_DATE_FORMAT, 
            fn($value, $base) => $value->gte($base)
        );
    }

    /**
     * Validate Jalali datetime is after
     */
    public function validateDateTimeAfter(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison(
            $value, 
            $parameters, 
            self::DEFAULT_DATETIME_FORMAT, 
            fn($value, $base) => $value->gt($base)
        );
    }

    /**
     * Validate Jalali datetime is after or equal
     */
    public function validateDateTimeAfterEqual(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison(
            $value, 
            $parameters, 
            self::DEFAULT_DATETIME_FORMAT, 
            fn($value, $base) => $value->gte($base)
        );
    }

    /**
     * Validate Jalali date is before
     */
    public function validateDateBefore(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison(
            $value, 
            $parameters, 
            self::DEFAULT_DATE_FORMAT, 
            fn($value, $base) => $value->lt($base)
        );
    }

    /**
     * Validate Jalali date is before or equal
     */
    public function validateDateBeforeEqual(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison(
            $value, 
            $parameters, 
            self::DEFAULT_DATE_FORMAT, 
            fn($value, $base) => $value->lte($base)
        );
    }

    /**
     * Validate Jalali datetime is before
     */
    public function validateDateTimeBefore(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison(
            $value, 
            $parameters, 
            self::DEFAULT_DATETIME_FORMAT, 
            fn($value, $base) => $value->lt($base)
        );
    }

    /**
     * Validate Jalali datetime is before or equal
     */
    public function validateDateTimeBeforeEqual(string $attribute, $value, array $parameters): bool
    {
        return $this->validateDateTimeComparison(
            $value, 
            $parameters, 
            self::DEFAULT_DATETIME_FORMAT, 
            fn($value, $base) => $value->lte($base)
        );
    }

    /**
     * Replace date or datetime in message
     */
    public function replaceDateOrDatetime($message, $attribute, $rule, $parameters): string
    {
        return $message;
    }

    /**
     * Replace date comparison in message
     */
    public function replaceDateAfterOrBeforeOrEqual($message, $attribute, $rule, $parameters): string
    {
        return $this->replaceComparisonDateInMessage($message, $parameters, self::DEFAULT_DATE_FORMAT);
    }

    /**
     * Replace datetime comparison in message
     */
    public function replaceDateTimeAfterOrBeforeOrEqual($message, $attribute, $rule, $parameters): string
    {
        return $this->replaceComparisonDateInMessage($message, $parameters, self::DEFAULT_DATETIME_FORMAT);
    }

    /**
     * Core validation method for date/time values
     */
    protected function validateDateTimeValue($value, array $parameters, string $defaultFormat): bool
    {
        if (!is_string($value)) {
            return false;
        }

        $format = $parameters[0] ?? $defaultFormat;

        try {
            Verta::parseFormat($format, $value);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Core comparison validation method
     */
    protected function validateDateTimeComparison(
        $value,
        array $parameters,
        string $defaultFormat,
        callable $comparison
    ): bool {
        if (!is_string($value)) {
            return false;
        }

        $format = $parameters[1] ?? $defaultFormat;

        try {
            $base = isset($parameters[0]) ? Verta::parseFormat($format, $parameters[0]) : null;
            $parsedValue = Verta::parseFormat($format, $value);
            
            return $comparison($parsedValue, $base);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Replace date in validation message
     */
    protected function replaceComparisonDateInMessage(
        string $message,
        array $parameters,
        string $defaultFormat
    ): string {
        $format = $parameters[1] ?? $defaultFormat;
        $date = $parameters[0] ?? Verta::instance()->format($format);

        if (Verta::getLocale() != 'en') {
            $en = Verta::getMessages('en');
            $to = Verta::getMessages();
            $date = str_replace(array_values($en['numbers']), array_values($to['numbers']), $date);
        }

        return str_replace(':date', $date, $message);
    }
}
