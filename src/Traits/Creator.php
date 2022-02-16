<?php

namespace Hekmatinasser\Verta\Traits;

use DateTime;
use DateTimeZone;
use Exception;
use InvalidArgumentException;

trait Creator
{
    /**
     * create object of Jalali
     *
     * @param DateTime|string|int|null $datetime [optional]
     * @param DateTimeZone|string|null $timezone [optional]
     * @internal param timestamp $timestamp [optional]
     */
    public function __construct($datetime = null, $timezone = null)
    {
        $dt = $datetime;
        if (empty($datetime)) {
            $dt = 'now';
        } elseif (is_string($datetime)) {
            $dt = self::faToEnNumbers(self::arToEnNumbers($datetime));
        } elseif ($datetime instanceof DateTime) {
            $dt = "@{$datetime->getTimestamp()}";
        } elseif (is_int($datetime)) {
            $dt = "@$datetime";
        }

        try {
            parent::__construct($dt, static::createTimeZone($timezone));
            self::loadMessages();
        } catch (Exception $exception) {
            throw new InvalidArgumentException(sprintf("Unknown datetime '%s'", $datetime));
        }
    }

    /**
     * Create a Verta now datetime
     *
     *
     * @param null $timezone
     * @return static
     */
    public static function now($timezone = null)
    {
        return new static(null, $timezone);
    }

    /**
     * Create a Verta instance for today.
     *
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function today($timezone = null)
    {
        return (new static(null, $timezone))->startDay();
    }

    /**
     * Create a Verta instance for tomorrow.
     *
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function tomorrow($timezone = null)
    {
        return (new static(null, $timezone))->addDay()->startDay();
    }

    /**
     * Create a Verta instance for yesterday.
     *
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function yesterday($timezone = null)
    {
        return (new static(null, $timezone))->subDay()->startDay();
    }

    /**
     * Create a Verta instance from a DateTime one
     *
     * @param $datetime [optional]
     * @param \DateTimeZone|string|null $timezone [optional]
     *
     * @return static
     */
    public static function instance($datetime = null, $timezone = null)
    {
        return new static($datetime, $timezone);
    }

    /**
     * Get a copy of the instance.
     *
     * @return static
     */
    public function copy()
    {
        return clone $this;
    }

    /**
     * Get a copy of the instance.
     *
     * @return static
     */
    public function clone()
    {
        return clone $this;
    }

    /**
     * Create a DateTime instance from Verta
     *
     * @return datetime $datetime
     */
    public function datetime()
    {
        return new DateTime(date('Y-m-d H:i:s', $this->getTimestamp()), $this->getTimezone());
    }

    /**
     * Create a Verta instance from a DateTime one
     *
     * @param $datetime [optional]
     * @param bool $timezone [optional]
     *
     * @return static
     */
    public static function parse($datetime, $timezone = null)
    {
        self::loadMessages();
        $names = array_map(function ($value) {
            return " $value ";
        }, array_values(self::$messages['year_months']));
        $values = array_map(function ($value) {
            return "-$value-";
        }, range(1, 12));

        $formatted = str_replace($names, $values, $datetime);
        $formatted = str_replace(array_values(self::$messages['year_months']), range(1, 12), $formatted);
        $parse = date_parse($formatted);
        if ($parse['error_count'] > 0 || ! self::isValidDate($parse['year'], $parse['month'], $parse['day']) || ! self::isValidTime($parse['hour'], $parse['minute'], $parse['second'])) {
            throw new InvalidArgumentException(sprintf("Unknown datetime '%s'", $datetime));
        }

        list($year, $month, $day) = self::getGregorian($parse['year'], $parse['month'], $parse['day']);
        list($hour, $minute, $second) = [$parse['hour'], $parse['minute'], $parse['second']];

        $datetime = sprintf('%04s-%02s-%02s %02s:%02s:%02s', $year, $month, $day, $hour, $minute, $second);

        return new static($datetime, $timezone);
    }

    /**
     * Create a Verta instance from a DateTime one
     *
     * @param string $format
     * @param string $datetime [optional]
     * @param bool $timezone [optional]
     * @return static
     */
    public static function parseFormat($format, $datetime, $timezone = null)
    {
        self::loadMessages();
        $formatted = str_replace(array_values(self::$messages['year_months']), range(1, 12), $datetime);

        $parse = date_parse_from_format($format, $formatted);
        if ($parse['error_count'] > 0 || ! self::isValidDate($parse['year'], $parse['month'], $parse['day']) || ! self::isValidTime($parse['hour'], $parse['minute'], $parse['second'])) {
            throw new InvalidArgumentException(sprintf("Unknown datetime '%s'", $datetime));
        }
        list($year, $month, $day) = self::getGregorian($parse['year'], $parse['month'], $parse['day']);
        list($hour, $minute, $second) = [$parse['hour'], $parse['minute'], $parse['second']];

        $datetime = sprintf('%04s-%02s-%02s %02s:%02s:%02s', $year, $month, $day, $hour, $minute, $second);

        return new static($datetime, $timezone);
    }

    /**
     * Create a new Verta instance from a specific date and time gregorain.
     *
     * If any of feild are set to null their now() values will
     * be used.
     *
     * @param int|null                  $year
     * @param int|null                  $month
     * @param int|null                  $day
     * @param int|null                  $hour
     * @param int|null                  $minute
     * @param int|null                  $second
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function create($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $timezone = null)
    {
        return static::createGregorian($year, $month, $day, $hour, $minute, $second, $timezone);
    }

    /**
     * Create a Verta from just a date gregorian.
     *
     * @param int|null                  $year
     * @param int|null                  $month
     * @param int|null                  $day
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function createDate($year = null, $month = null, $day = null, $timezone = null)
    {
        return static::create($year, $month, $day, null, null, null, $timezone);
    }

    /**
     * Create a Verta instance from just a time gregorian.
     *
     * @param int|null                  $hour
     * @param int|null                  $minute
     * @param int|null                  $second
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function createTime($hour = null, $minute = null, $second = null, $timezone = null)
    {
        return static::create(null, null, null, $hour, $minute, $second, $timezone);
    }

    /**
     * Create a Verta instance from a timestamp.
     *
     * @param int                       $timestamp
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function createTimestamp($timestamp, $timezone = null)
    {
        return static::instance($timestamp, $timezone);
    }

    /**
     * @param null $timezone
     * @return DateTimeZone|string|null
     */
    protected static function createTimeZone($timezone = null)
    {
        if ($timezone === null) {
            return new DateTimeZone(date_default_timezone_get());
        } elseif ($timezone instanceof DateTimeZone) {
            return $timezone;
        } else {
            $tz = @timezone_open(strval($timezone));
            if ($tz === false) {
                throw new InvalidArgumentException(sprintf("Unknown timezone '%s'", $tz));
            }

            return $tz;
        }
    }

    /**
     * Create a new Verta instance from a specific date and time gregorain.
     *
     * If any of feild are set to null their now() values will
     * be used.
     *
     * @param int|null $year
     * @param int|null $month
     * @param int|null $day
     * @param int|null $hour
     * @param int|null $minute
     * @param int|null $second
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function createGregorian($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $timezone = null)
    {
        $now = (new DateTime())->format('Y-n-j-G-i-s');
        $defaults = array_combine(['year', 'month', 'day', 'hour', 'minute', 'second'], explode('-', $now));

        $year = $year ?? intval($defaults['year']);
        $month = $month ?? intval($defaults['month']);
        $day = $day ?? intval($defaults['day']);
        $hour = $hour ?? intval($defaults['hour']);
        $minute = $minute ?? intval($defaults['minute']);
        $second = $second ?? intval($defaults['second']);

        if (! checkdate($month, $day, $year) || ! static::isValidTime($hour, $minute, $second)) {
            throw new \InvalidArgumentException('Unknown datetime');
        }

        return new static(sprintf('%s-%s-%s %s:%s:%s', $year, $month, $day, $hour, $minute, $second), $timezone);
    }

    /**
     * Create a Verta from just a date gregorian.
     *
     * @param int|null $year
     * @param int|null $month
     * @param int|null $day
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function createGregorianDate($year = null, $month = null, $day = null, $timezone = null)
    {
        return static::createGregorian($year, $month, $day, null, null, null, $timezone);
    }

    /**
     * Create a Verta instance from just a time gregorian.
     *
     * @param int|null $hour
     * @param int|null $minute
     * @param int|null $second
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function createGregorianTime($hour = null, $minute = null, $second = null, $timezone = null)
    {
        return static::createGregorian(null, null, null, $hour, $minute, $second, $timezone);
    }

    /**
     * Create a new Verta instance from a specific date and time.
     *
     * If any of feild are set to null their now() values will
     * be used.
     *
     * @param int|null $year
     * @param int|null $month
     * @param int|null $day
     * @param int|null $hour
     * @param int|null $minute
     * @param int|null $second
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function createJalali($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $timezone = null)
    {
        $now = (new static())->format('Y-n-j-G-i-s');
        $defaults = array_combine(['year', 'month', 'day', 'hour', 'minute', 'second'], explode('-', $now));

        $year = $year ?? intval($defaults['year']);
        $month = $month ?? intval($defaults['month']);
        $day = $day ?? intval($defaults['day']);
        $hour = $hour ?? intval($defaults['hour']);
        $minute = $minute ?? intval($defaults['minute']);
        $second = $second ?? intval($defaults['second']);

        if (! static::isValidDate($year, $month, $day) || ! static::isValidTime($hour, $minute, $second)) {
            throw new \InvalidArgumentException('Unknown datetime');
        }

        return static::parse(sprintf('%s-%s-%s %s:%s:%s', $year, $month, $day, $hour, $minute, $second));
    }

    /**
     * Create a Verta from just a date.
     *
     * @param int|null $year
     * @param int|null $month
     * @param int|null $day
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function createJalaliDate($year = null, $month = null, $day = null, $timezone = null)
    {
        return static::createJalali($year, $month, $day, null, null, null, $timezone);
    }

    /**
     * Create a Verta instance from just a time.
     *
     * @param int|null $hour
     * @param int|null $minute
     * @param int|null $second
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function createJalaliTime($hour = null, $minute = null, $second = null, $timezone = null)
    {
        return static::createJalali(null, null, null, $hour, $minute, $second, $timezone);
    }
}
