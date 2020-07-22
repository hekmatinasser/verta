<?php

namespace Hekmatinasser\Verta;

/*
 * This file is part of the Jalali package.
 *
 * (c) Nasser Hekmati <hekmati.nasser@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use DateTime;
use DateTimeZone;
use InvalidArgumentException;
use Hekmatinasser\Notowo\Notowo;

class Verta extends DateTime {

    /*****************************  STATCT VARIABLE  ****************************/

    /**
     * The day constants
     */
    const SATURDAY = 0;
    const SUNDAY = 1;
    const MONDAY = 2;
    const TUESDAY = 3;
    const WEDNESDAY = 4;
    const THURSDAY = 5;
    const FRIDAY = 6;

    /**
     * Number unit in date
     */
    const YEARS_PER_CENTURY = 100;
    const YEARS_PER_DECADE = 10;
    const MONTHS_PER_YEAR = 12;
    const MONTHS_PER_QUARTER = 3;
    const WEEKS_PER_YEAR = 52;
    const WEEKS_PER_MONTH = 4.35;
    const DAYS_PER_WEEK = 7;
    const HOURS_PER_DAY = 24;
    const MINUTES_PER_HOUR = 60;
    const SECONDS_PER_MINUTE = 60;

    /**
     * Word use in format datetime.
     */
    const DEFAULT_STRING_FORMAT = 'Y-m-d H:i:s';

    /**
     * Format to use for __toString.
     *
     * @var string
     */
    protected static $stringFormat = self::DEFAULT_STRING_FORMAT;

    /**
     * First day of week.
     *
     * @var int
     */
    protected static $weekStartsAt = self::SATURDAY;

    /**
     * Last day of week.
     *
     * @var int
     */
    protected static $weekEndsAt = self::FRIDAY;

    /**
     * Days of weekend.
     *
     * @var array
     */
    protected static $weekendDays = array(
        self::THURSDAY,
        self::FRIDAY,
    );

    /**
     * Default format to use for __toString method when type juggling occurs.
     */
    const AM = 'ق.ظ';
    const PM = 'ب.ظ';
    const ANTE_MERIDIEM = 'قبل از ظهر';
    const POST_MERIDIEM = 'بعد از ظهر';
    const NUMBER_TH = ' ام';
    const PRE = 'قبل';
    const NOW = 'الان';
    const POST = 'بعد';

    /**
     * number day in months gregorian
     *
     * @var array
     */
    protected static $daysMonthGregorian = array(
        31,
        28,
        31,
        30,
        31,
        30,
        31,
        31,
        30,
        31,
        30,
        31,
    );

    /**
     * number day in month jalali
     *
     * @var array
     */
    protected static $daysMonthJalali = array(
        31,
        31,
        31,
        31,
        31,
        31,
        30,
        30,
        30,
        30,
        30,
        29,
    );

    /**
     * month name jalali
     *
     * @var array
     */
    protected static $monthYear = array(
        'فروردین',
        'اردیبهشت',
        'خرداد',
        'تیر',
        'مرداد',
        'شهریور',
        'مهر',
        'آبان',
        'آذر',
        'دی',
        'بهمن',
        'اسفند',
    );

    /**
     * Names of days of the week.
     *
     * @var array
     */
    protected static $dayWeek = array(
        'شنبه',
        'یکشنبه',
        'دوشنبه',
        'سه شنبه',
        'چهارشنبه',
        'پنج شنبه',
        'جمعه',
    );

    /**
     * unit date name.
     *
     * @var array
     */
    protected static $unitName = array(
        'ثانیه',
        'دقیقه',
        'ساعت',
        'روز',
        'هفته',
        'ماه',
        'سال',
        'قرن'
    );

    /**
     * unit date number.
     *
     * @var array
     */
    protected static $unitNumber = array(
        self::SECONDS_PER_MINUTE,
        self::MINUTES_PER_HOUR,
        self::HOURS_PER_DAY,
        self::DAYS_PER_WEEK,
        self::WEEKS_PER_MONTH,
        self::MONTHS_PER_YEAR,
        self::YEARS_PER_DECADE,
    );

    /**
     * arabic number.
     *
     * @var array
     */

    protected static $arabicNumber = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

    /**
     * persian number.
     *
     * @var array
     */
    protected static $persianNumber = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

    /**
     * english number.
     *
     * @var array
     */
    protected static $englishNumber = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    /*****************************  CONSTRUCT  ****************************/

    /**
     * create object of Jalali
     *
     * @param null $datetime
     * @param bool $timezone [optional]
     * @internal param timestamp $timestamp [optional]
     */
    public function __construct($datetime = null, $timezone = null) {
        if ($datetime === null) {
            $object = new DateTime();
            $instance = $object->getTimestamp();
        }
        elseif (is_string($datetime)){
            $datetime = self::faToEnNumbers(self::arToEnNumbers($datetime));
            $object = date_create($datetime);
            if ($object === false) {
                throw new InvalidArgumentException(sprintf("Unknown datetime '%s'", $datetime));
            }
            $instance = $object->getTimestamp();
        }
        elseif ($datetime instanceof DateTime || $datetime instanceof Verta) {
            $instance = $datetime->getTimestamp();
        }
        elseif (is_numeric($datetime)) {
            $instance = $datetime;
        }
        else {
            throw new \InvalidArgumentException(sprintf("Unknown datetime '%s'", $datetime));
        }

        $timezone = static::createTimeZone($timezone);
        parent::__construct(date('Y-m-d H:i:s.u', $instance), $timezone);
    }

    /**
     * Create a Verta now datetime
     *
     *
     * @param null $timezone
     * @return static
     */
    public static function now($timezone = null) {
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
        return static::now($timezone)->startDay();
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
        return static::today($timezone)->addDay();
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
        return static::today($timezone)->subDay();
    }

    /**
     * Create a Verta instance from a DateTime one
     *
     * @param timestamp $datetime [optional]
     * @param bool $timezone [optional]
     *
     * @return static
     */
    public static function instance($datetime = null, $timezone = null) {
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
     * Create a DateTime instance from Verta
     *
     * @return datetime $datetime
     */
    public function datetime() {
        return new DateTime(date('Y-m-d H:i:s.u', $this->getTimestamp()), $this->getTimeZone());
    }

    /**
     * Create a Verta instance from a DateTime one
     *
     * @param timestamp $datetime [optional]
     * @param bool $timezone [optional]
     *
     * @return static
     */
    public static function parse($datetime, $timezone = null) {
        $monthName = array_map(function ($value) {
            return ' ' . $value . ' ';
        }, self::$monthYear);
        $monthValue = array_map(function ($value) {
            return '-' . $value . '-';
        }, range(1,12));
        $datetime = str_replace($monthName, $monthValue, $datetime);

        $parse = date_parse($datetime);
        if($parse['error_count'] == 0){
            list($year, $month, $day) = self::getGregorian($parse['year'], $parse['month'], $parse['day']);
            list($hour,$minute, $second) = array($parse['hour'], $parse['minute'], $parse['second']);

            $timezone = self::createTimeZone($timezone);
            $datetime = new DateTime(sprintf('%04s-%02s-%02s %02s:%02s:%02s', $year, $month, $day, $hour, $minute, $second), $timezone);
            return new static($datetime);
        }
        else{
            throw new InvalidArgumentException(sprintf("Unknown datetime '%s'", $datetime));
        }
    }

    /**
     * Create a Verta instance from a DateTime one
     *
     * @param string $format
     * @param string $datetime [optional]
     * @param bool $timezone [optional]
     * @return static
     */
    public static function parseFormat($format,$datetime, $timezone = null) {
        $datetime = str_replace(self::$monthYear, range(1,12), $datetime);

        $parse = date_parse_from_format($format, $datetime);
        if($parse['error_count'] == 0 && self::isValidDate($parse['year'], $parse['month'], $parse['day']) && self::isValidTime($parse['hour'], $parse['minute'], $parse['second'])){
            list($year, $month, $day) = self::getGregorian($parse['year'], $parse['month'], $parse['day']);
            list($hour,$minute, $second) = array($parse['hour'], $parse['minute'], $parse['second']);

            $timezone = self::createTimeZone($timezone);
            $datetime = new DateTime(sprintf('%04s-%02s-%02s %02s:%02s:%02s', $year, $month, $day, $hour, $minute, $second), $timezone);
            return new static($datetime);
        }
        else{
            throw new InvalidArgumentException(sprintf("Unknown datetime '%s'", $datetime));
        }
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
     * @return DateTimeZone|null
     */
    protected static function createTimeZone($timezone = null) {
        if ($timezone === null) {
            $newTimezone = new DateTimeZone(date_default_timezone_get());
        }
        elseif ($timezone instanceof DateTimeZone) {
            $newTimezone = $timezone;
        }
        else {
            $newTimezone = @timezone_open(strval($timezone));
            if ($newTimezone === false) {
                throw new InvalidArgumentException(sprintf("Unknown timezone '%s'", $newTimezone));
            }
        }

        return $newTimezone;
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
    public static function createGregorian($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $timezone = null)
    {

        $object = new DateTime();
        $now = date('Y-n-j-G-i-s', $object->getTimestamp());
        $defaults = array_combine(array('year', 'month', 'day', 'hour', 'minute', 'second'), explode('-', $now));

        $year   = $year   === null ? intval($defaults['year'])   : $year;
        $month  = $month  === null ? intval($defaults['month'])  : $month;
        $day    = $day    === null ? intval($defaults['day'])    : $day;
        $hour   = $hour   === null ? intval($defaults['hour'])   : $hour;
        $minute = $minute === null ? intval($defaults['minute']) : $minute;
        $second = $second === null ? intval($defaults['second']) : $second;

        if (!checkdate($month, $day, $year) || !static::isValidTime($hour, $minute, $second)) {
            throw new \InvalidArgumentException('Unknown datetime');
        }

        return static::instance(sprintf('%s-%s-%s %s:%s:%s', $year, $month, $day, $hour, $minute, $second), $timezone);
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
    public static function createGregorianDate($year = null, $month = null, $day = null, $timezone = null)
    {
        return static::createGregorian($year, $month, $day, null, null, null, $timezone);
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

    public static function createJalali($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $timezone = null)
    {
        $now = static::instance(null, $timezone)->format('Y-n-j-G-i-s');
        $defaults = array_combine(array('year', 'month', 'day', 'hour', 'minute', 'second'), explode('-', $now));

        $year   = $year   === null ? intval($defaults['year'])   : $year;
        $month  = $month  === null ? intval($defaults['month'])  : $month;
        $day    = $day    === null ? intval($defaults['day'])    : $day;
        $hour   = $hour   === null ? intval($defaults['hour'])   : $hour;
        $minute = $minute === null ? intval($defaults['minute']) : $minute;
        $second = $second === null ? intval($defaults['second']) : $second;

        if (!static::isValidDate($year, $month, $day) || !static::isValidTime($hour, $minute, $second)) {
            throw new \InvalidArgumentException('Unknown datetime');
        }

        return static::parse(sprintf('%s-%s-%s %s:%s:%s', $year, $month, $day, $hour, $minute, $second));
    }

    /**
     * Create a Verta from just a date.
     *
     * @param int|null                  $year
     * @param int|null                  $month
     * @param int|null                  $day
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
     * @param int|null                  $hour
     * @param int|null                  $minute
     * @param int|null                  $second
     * @param \DateTimeZone|string|null $timezone
     *
     * @return static
     */
    public static function createJalaliTime($hour = null, $minute = null, $second = null, $timezone = null)
    {
        return static::createJalali(null, null, null, $hour, $minute, $second, $timezone);
    }

    /*****************************  ACCESS  ****************************/

    /**
     * Get a part of the Verta object
     *
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return string|int|\DateTimeZone
     */
    public function __get($name)
    {
        static $formats = array(
            'year' => 'Y',
            'month' => 'n',
            'day' => 'j',
            'hour' => 'G',
            'minute' => 'i',
            'second' => 's',
            'micro' => 'u',
            'dayOfWeek' => 'w',
            'dayOfYear' => 'z',
            'weekOfYear' => 'W',
            'daysInMonth' => 't',
            'timestamp' => 'U',
        );

        switch (true) {
            case isset($formats[$name]):
                return (int) $this->format($formats[$name]);

            case $name === 'quarter':
                return (int) ceil($this->month / static::MONTHS_PER_QUARTER);

            case $name === 'timezone':
                return $this->getTimezone()->getName();

            default:
                throw new InvalidArgumentException(sprintf("Unknown getter '%s'", $name));
        }
    }

    /**
     * Check if an attribute exists on the object
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        try {
            $this->__get($name);
        } catch (InvalidArgumentException $e) {
            return false;
        }

        return true;
    }

    /**
     * Set a part of the Verta object
     *
     * @param string                   $name
     * @param string|int|\DateTimeZone $value
     *
     * @throws \InvalidArgumentException
     */
    public function __set($name, $value)
    {
        switch ($name) {
            case 'year':
            case 'month':
            case 'day':
            case 'hour':
            case 'minute':
            case 'second':
                list($year, $month, $day, $hour, $minute, $second) = explode('-', $this->format('Y-n-j-G-i-s'));
                $$name = $value;
                $this->setDateTime($year, $month, $day, $hour, $minute, $second);
                break;

            case 'timestamp':
                $this->setTimestamp($value);
                break;

            case 'timezone':
            case 'tz':
                $this->setTimezone(new DateTimeZone($value));
                break;

            default:
                throw new InvalidArgumentException(sprintf("Unknown setter '%s'", $name));
        }
    }

    /**
     * Set the instance's year
     *
     * @param int $value
     *
     * @return static
     */
    public function year($value)
    {
        $this->year = $value;

        return $this;
    }

    /**
     * Set the instance's month
     *
     * @param int $value
     *
     * @return static
     */
    public function month($value)
    {
        $this->month = $value;

        return $this;
    }

    /**
     * Set the instance's day
     *
     * @param int $value
     *
     * @return static
     */
    public function day($value)
    {
        $this->day = $value;

        return $this;
    }

    /**
     * Set the instance's hour
     *
     * @param int $value
     *
     * @return static
     */
    public function hour($value)
    {
        $this->hour = $value;

        return $this;
    }

    /**
     * Set the instance's minute
     *
     * @param int $value
     *
     * @return static
     */
    public function minute($value)
    {
        $this->minute = $value;

        return $this;
    }

    /**
     * Set the instance's second
     *
     * @param int $value
     *
     * @return static
     */
    public function second($value)
    {
        $this->second = $value;

        return $this;
    }

    /**
     * Set the instance's timestamp
     *
     * @param int $value
     *
     * @return static
     */
    public function timestamp($value)
    {
        return parent::setTimestamp($value);
    }

    /**
     * Alias for setTimezone()
     *
     * @param \DateTimeZone|string $value
     *
     * @return static
     */
    public function timezone($value)
    {
        return parent::setTimezone(new DateTimeZone($value));
    }

    /**
     * Set the date and time all together
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @param int $hour
     * @param int $minute
     * @param int $second
     *
     * @return static
     */
    public function setDateTime($year, $month, $day, $hour, $minute, $second = 0, $microseconds = 0)
    {
        return $this->setDate($year, $month, $day)->setTime($hour, $minute, $second, $microseconds);
    }

    /**
     * Sets the current date of the DateTime object to a different date.
     * Calls modify as a workaround for a php bug
     *
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return static
     */
    public function setDate($year, $month, $day)
    {
        list($year, $month, $day) = self::getGregorian($year, $month, $day);

        return parent::setDate($year, $month, $day);
    }

    /**
     * Set the time by time string
     *
     * @param string $time
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function setTimeString($time)
    {
        $time = explode(':', $time);

        $hour = $time[0];
        $minute = isset($time[1]) ? $time[1] : 0;
        $second = isset($time[2]) ? $time[2] : 0;

        return $this->setTime($hour, $minute, $second, 0);
    }

    /*****************************  STRING FORMATED  ****************************/

    /**
     * Reset the format used to the default when type juggling a Verta instance to a string
     */
    public static function resetStringFormat()
    {
        static::setStringFormat(static::DEFAULT_STRING_FORMAT);
    }

    /**
     * Set the default format used when type juggling a Verta instance to a string
     *
     * @param string $format
     */
    public static function setStringFormat($format)
    {
        static::$stringFormat = $format;
    }

    /**
     * Format the instance as a string using the set format
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format(static::$stringFormat);
    }

    /**
     * The format of the outputted date string (jalali equivalent of php date() function)
     *
     * @param string $format for example 'Y-m-d H:i:s'
     * @return string
     */
    protected function date($format){
        $timestamp = $this->getTimestamp();


        list( $gYear, $gMonth, $gDay, $gWeek ) = explode( '-', parent::format( 'Y-m-d-w' ) );
        list( $pYear, $pMonth, $pDay ) = static::getJalali( $gYear, $gMonth, $gDay );
        $pWeek = ( $gWeek + 1 );

        if ($pWeek >= 7) {
            $pWeek = 0;
        }

        if ($format == '\\') {
            $format = '//';
        }

        $lenghFormat = strlen( $format );
        $i = 0;
        $result = '';

        while ($i < $lenghFormat) {
            $par =  $format[$i];
            if ($par == '\\') {
                $result .= $format[++$i];
                $i++;
                continue;
            }
            switch ($par) {
                # Day
                case 'd':
                    $result .= sprintf( '%02s', $pDay );
                    break;

                case 'D':
                    $result .= substr( static::$dayWeek[ $pWeek ], 0, 2 );
                    break;

                case 'j':
                    $result .= $pDay;
                    break;

                case 'l':
                    $result .= static::$dayWeek[ $pWeek ];
                    break;

                case 'N':
                    $result .= $pWeek + 1;
                    break;

                case 'w':
                    $result .= $pWeek;
                    break;

                case 'z':
                    $result .= $this->daysYear( $pMonth, $pDay );
                    break;

                case 'S':
                    $result .= self::NUMBER_TH;
                    break;

                # Week
                case 'W':
                    $result .= ceil( $this->daysYear( $pMonth, $pDay ) / 7 );
                    break;

                # Month
                case 'F':
                    $result .= static::$monthYear[ $pMonth - 1 ];
                    break;

                case 'm':
                    $result .= sprintf( '%02s', $pMonth );
                    break;

                case 'M':
                    $result .= substr( static::$monthYear[ $pMonth - 1 ], 0, 6 );
                    break;

                case 'n':
                    $result .= $pMonth;
                    break;

                case 't':
                    $result .= static::isLeapYear( $pYear ) && ( $pMonth == 12 ) ? 30 : static::$daysMonthJalali[ intval( $pMonth ) - 1 ];
                    break;

                # Years
                case 'L':
                    $result .= intval( $this->isLeapYear( $pYear ) );
                    break;

                case 'Y':
                case 'o':
                    $result .= $pYear;
                    break;

                case 'y':
                    $result .= substr( $pYear, 2 );
                    break;

                # Time
                case 'a':
                case 'A':
                    if (parent::format( 'a' ) == 'am') {
                        $result .= ( ( $par == 'a' ) ? self::AM : self::ANTE_MERIDIEM );
                    } else {
                        $result .= ( ( $par == 'a' ) ? self::PM : self::POST_MERIDIEM );
                    }
                    break;

                case 'B':
                case 'g':
                case 'G':
                case 'h':
                case 'H':
                case 's':
                case 'u':
                case 'i':
                    # Timezone
                case 'e':
                case 'I':
                case 'O':
                case 'P':
                case 'T':
                case 'Z':
                    $result .= parent::format( $par );
                    break;

                # Full Date/Time
                case 'c':
                    $result .= ( $pYear . '-' . $pMonth . '-' . $pDay . ' ' . parent::format( 'H:i:s P' ) );
                    break;

                case 'r':
                    $result .= ( substr( static::$dayWeek[ $pWeek ], 0, 2 ) . '، ' . $pDay . ' ' . substr( static::$monthYear[ $pMonth ], 0, 6 ) . ' ' . $pYear . ' ' . parent::format( 'H:i:s P' ) );
                    break;

                case 'U':
                    $result .= $timestamp;
                    break;

                default:
                    $result .= $par;
            }

            $i++;
        }
        return $result;
    }

    /**
     * The format of the outputted date string (jalali equivalent of php date() function)
     *
     * @param string $format for example 'Y-m-d H:i:s'
     * @return string
     */
    protected function dateWord($format){

        $timestamp = $this->getTimestamp();

        list($gYear, $gMonth, $gDay, $gWeek) = explode('-', date('Y-m-d-w', $timestamp));
        list($pYear, $pMonth, $pDay) = static::getJalali($gYear, $gMonth, $gDay);
        $pWeek = ($gWeek + 1);

        if ($pWeek >= 7) {
            $pWeek = 0;
        }

        if ($format == '\\') {
            $format = '//';
        }

        $lenghFormat = strlen($format);
        $i = 0;
        $result = '';

        $word = new Notowo(0, 'fa');

        while ($i < $lenghFormat) {
            $par = $format[$i];
            if ($par == '\\') {
                $result .= $format[++$i];
                $i ++;
                continue;
            }
            switch ($par) {
                # Day
                case 'd':
                case 'j':
                    $result .= $word->getWord(strval($pDay));
                    break;

                case 'D':
                    $result .= substr(static::$dayWeek[$pWeek], 0, 2);
                    break;

                case 'l':
                    $result .= static::$dayWeek[$pWeek];
                    break;

                case 'N':
                    $result .= $word->getWord(strval($pWeek + 1));
                    break;

                case 'w':
                    $result .= $word->getWord(strval($pWeek));
                    break;

                case 'z':
                    $result .= $word->getWord(strval($this->daysYear($pMonth, $pDay)));
                    break;

                case 'S':
                    $result .= self::NUMBER_TH;
                    break;

                # Week
                case 'W':
                    $result .= $word->getWord(strval(ceil($this->daysYear($pMonth, $pDay) / 7)));
                    break;

                # Month
                case 'F':
                    $result .= static::$monthYear[$pMonth-1];
                    break;

                case 'm':
                case 'n':
                    $result .= $word->getWord(strval($pMonth));
                    break;

                case 'M':
                    $result .= substr(static::$monthYear[$pMonth-1], 0, 6);
                    break;

                case 't':
                    $result .= $word->getWord(strval(static::isLeapYear($pYear) && ($pMonth == 12) ? 30 : static::$daysMonthJalali[intval($pMonth)-1]));
                    break;

                # Years
                case 'L':
                    $result .= intval($this->isLeapYear($pYear));
                    break;

                case 'Y':
                case 'o':
                    $result .= $word->getWord(strval($pYear));
                    break;

                case 'y':
                    $result .= $word->getWord(strval(substr($pYear, 2)));
                    break;

                # Time
                case 'a':
                case 'A':
                    if (date('a', $timestamp) == 'am') {
                        $result .= (($par == 'a') ? self::AM : self::ANTE_MERIDIEM);
                    } else {
                        $result .= (($par == 'a') ? self::PM : self::POST_MERIDIEM);
                    }
                    break;

                case 'B':
                case 'g':
                case 'G':
                case 'h':
                case 'H':
                case 's':
                case 'u':
                case 'i':
                    $result .= $word->getWord(strval(date($par, $timestamp)));
                    break;
                case 'e':
                case 'I':
                case 'O':
                case 'P':
                case 'T':
                case 'Z':
                    $result .= date($par, $timestamp);
                    break;

                # Full Date/Time
                case 'c':
                    $result .= $this->dateWord('Y, m, d, H:i:s P');
                    break;

                case 'r':
                    $result .=  $this->dateWord('l Y, m, d, H:i:s P');
                    break;

                case 'U':
                    $result .= $word->getWord(strval($timestamp));
                    break;

                default:
                    $result .= $par;
            }
            $i ++;
        }

        return $result;
    }

    /**
     * return day number from first day of year
     *
     * @param int $month
     * @param int $day
     * @return type
     * @since 5.0.0
     */
    protected function daysYear($month, $day) {
        $days = 0;
        for ($i = 1; $i < $month; $i ++) {
            $days += static::$daysMonthJalali[$i-1];
        }
        return ($days + $day);
    }

    /**
     * The format of the outputted date string (jalali equivalent of php strftime() function)
     *
     * @param $format
     * @return string
     */
    protected function strftime($format)
    {
        $str_format_code = array(
            "%a",
            "%A",
            "%d",
            "%e",
            "%j",
            "%u",
            "%w",
            "%U",
            "%V",
            "%W",
            "%b",
            "%B",
            "%h",
            "%m",
            "%C",
            "%g",
            "%G",
            "%y",
            "%Y",
            "%H",
            "%I",
            "%l",
            "%M",
            "%p",
            "%P",
            "%r",
            "%R",
            "%S",
            "%T",
            "%X",
            "%z",
            "%Z",
            "%c",
            "%D",
            "%F",
            "%s",
            "%x",
            "%n",
            "%t",
            "%%",
        );

        $date_format_code = array(
            "D",
            "l",
            "d",
            "j",
            "z",
            "N",
            "w",
            "W",
            "W",
            "W",
            "M",
            "F",
            "M",
            "m",
            "y",
            "y",
            "y",
            "y",
            "Y",
            "H",
            "h",
            "g",
            "i",
            "A",
            "a",
            "h:i:s A",
            "H:i",
            "s",
            "H:i:s",
            "h:i:s",
            "H",
            "H",
            "D j M H:i:s",
            "d/m/y",
            "Y-m-d",
            "U",
            "d/m/y",
            "\n",
            "\t",
            "%",
        );

        return str_replace($str_format_code, $date_format_code, $format);
    }

    /**
     * The format of the outputted date string (jalali equivalent of php strftime() function)
     *
     * @param $format
     * @return string
     */
    public function format($format) {
        return $this->date($this->strftime($format));
    }

    /**
     * The format of the outputted date string (gregorian)
     *
     * @param $format
     * @return string
     */
    public function formatGregorian($format) {

        return $this->datetime()->format($format);
    }

    /**
     * Format the instance as date
     *
     * @return string
     */
    public function formatDatetime()
    {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * Format the instance as date
     *
     * @return string
     */
    public function formatDate()
    {
        return $this->format('Y-m-d');
    }

    /**
     * Format the instance as time
     *
     * @return string
     */
    public function formatTime()
    {
        return $this->format('H:i:s');
    }

    /**
     * Format the instance as date
     *
     * @return string
     */
    public function formatJalaliDatetime()
    {
        return $this->format('Y/n/j H:i:s');
    }

    /**
     * Format the instance as date
     *
     * @return string
     */
    public function formatJalaliDate()
    {
        return $this->format('Y/n/j');
    }

    /**
     * get difference in all
     *
     * @param Verta|null $v
     *
     * @return string
     */
    public function formatDifference(Verta $v = null)
    {
        $difference = $this->diffSeconds($v);
        $absolute = $difference < 0 ? self::POST : self::PRE;
        $difference = abs($difference);

        for ($j = 0; $difference >= static::$unitNumber[$j] and $j < count(static::$unitNumber) - 1; $j++) {
            $difference /= static::$unitNumber[$j];
        }
        $difference = intval(round($difference));

        if($difference === 0) {
            return self::NOW;
        }

        return sprintf('%s %s %s', $difference, static::$unitName[$j], $absolute);
    }

    public function formatWord($format)
    {
        return $this->dateWord($this->strftime($format));
    }

    /**
     * Convert english numbers to persian numbers
     *
     * @param string $string
     * @return string
     */
    public static function enToFaNumbers($string)
    {
        return str_replace(self::$englishNumber, self::$persianNumber, $string);
    }

    /**
     * Convert english numbers to persian numbers
     *
     * @param string $string
     * @return string
     */
    public static function faToEnNumbers($string)
    {
        return str_replace(self::$persianNumber, self::$englishNumber, $string);
    }

    /**
     * Convert english numbers to persian numbers
     *
     * @param string $string
     * @return string
     */
    public static function arToEnNumbers($string)
    {
        return str_replace(self::$persianNumber, self::$englishNumber, $string);
    }

    /*****************************  COMPARISION  ****************************/

    /**
     * check jalali the instance is a leap year
     *
     * @param int $year
     * @return bool
     */
    public static function isLeapYear($year) {
        $mod = ($year % 33);
        if (($mod == 1) or ( $mod == 5) or ( $mod == 9) or ( $mod == 13) or ( $mod == 17) or ( $mod == 22) or ( $mod == 26) or ( $mod == 30)) {
            return true;
        }
        return false;
    }

    /**
     * validate a jalali date (jalali equivalent of php checkdate() function)
     *
     * @param int $month
     * @param int $day
     * @param int $year
     * @return bool
     */
    public static function isValidDate($year, $month, $day) {
        if($year < 0 || $year > 32766) {
            return false;
        }
        if($month < 1 || $month > 12) {
            return false;
        }
        $dayLastMonthJalali = static::isLeapYear($year) && ($month == 12) ? 30 : static::$daysMonthJalali[intval($month)-1];
        if($day < 1 || $day > $dayLastMonthJalali) {
            return false;
        }
        return true;
    }

    /**
     * validate a time
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @return bool
     */
    public static function isValidTime($hour, $minute, $second) {
        return $hour >= 0 && $hour <= 24
            && $minute >= 0 && $minute <= 59
            && $second >= 0 && $second <= 59;
    }

    /**
     * Get the difference in years
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffYears(Verta $v = null)
    {
        $v = $v ?: static::now($this->getTimezone());

        return (int) $this->diff($v->datetime())->format('%r%y');
    }

    /**
     * Get the difference in months
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffMonths(Verta $v = null)
    {
        $v = $v ?: static::now($this->getTimezone());

        return $this->diffYears($v) * static::MONTHS_PER_YEAR + (int) $this->diff($v->datetime())->format('%r%m');
    }

    /**
     * Get the difference in weeks
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffWeeks(Verta $v = null)
    {
        return (int) ($this->diffDays($v) / static::DAYS_PER_WEEK);
    }

    /**
     * Get the difference in days
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffDays(Verta $v = null)
    {
        $v = $v ?: static::now($this->getTimezone());

        return (int) $this->diff($v->datetime())->format('%r%a');
    }

    /**
     * Get the difference in hours
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffHours(Verta $v = null)
    {
        return (int) ($this->diffSeconds($v) / static::SECONDS_PER_MINUTE / static::MINUTES_PER_HOUR);
    }

    /**
     * Get the difference in minutes
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffMinutes(Verta $v = null)
    {
        return (int) ($this->diffSeconds($v) / static::SECONDS_PER_MINUTE);
    }

    /**
     * Get the difference in seconds
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffSeconds(Verta $v = null)
    {
        $v = $v ?: static::now($this->getTimezone());

        return $v->getTimestamp() - $this->getTimestamp();
    }

    /**
     * Determines if the instance is equal to another
     *
     * @param Verta $v
     *
     * @return bool
     */
    public function eq(Verta $v = null)
    {
        return $this == ($v ?: new static());
    }

    /**
     * Determines if the instance is equal to another
     *
     * @param Verta $v
     *
     * @see eq()
     *
     * @return bool
     */
    public function equalTo(Verta $v = null)
    {
        return $this->eq($v);
    }

    /**
     * Determines if the instance is not equal to another
     *
     * @param Verta $v
     *
     * @return bool
     */
    public function ne(Verta $v = null)
    {
        return !$this->eq($v);
    }

    /**
     * Determines if the instance is not equal to another
     *
     * @param Verta $v
     *
     * @see ne()
     *
     * @return bool
     */
    public function notEqualTo(Verta $v = null)
    {
        return $this->ne($v);
    }

    /**
     * Determines if the instance is greater (after) than another
     *
     * @param Verta $v
     *
     * @return bool
     */
    public function gt(Verta $v = null)
    {
        return $this > ($v ?: new static());
    }

    /**
     * Determines if the instance is greater (after) than another
     *
     * @param Verta $v
     *
     * @see gt()
     *
     * @return bool
     */
    public function greaterThan(Verta $v = null)
    {
        return $this->gt($v);
    }

    /**
     * Determines if the instance is greater (after) than or equal to another
     *
     * @param Verta $v
     *
     * @return bool
     */
    public function gte(Verta $v = null)
    {
        return $this >= ($v ?: new static());
    }

    /**
     * Determines if the instance is greater (after) than or equal to another
     *
     * @param Verta $v
     *
     * @see gte()
     *
     * @return bool
     */
    public function greaterThanOrEqualTo(Verta $v = null)
    {
        return $this->gte($v);
    }

    /**
     * Determines if the instance is less (before) than another
     *
     * @param Verta $v
     *
     * @return bool
     */
    public function lt(Verta $v = null)
    {
        return $this < ($v ?: new static());
    }

    /**
     * Determines if the instance is less (before) than another
     *
     * @param Verta $v
     *
     * @see lt()
     *
     * @return bool
     */
    public function lessThan(Verta $v = null)
    {
        return $this->lt($v);
    }

    /**
     * Determines if the instance is less (before) or equal to another
     *
     * @param Verta $v
     *
     * @return bool
     */
    public function lte(Verta $v = null)
    {
        return $this <= ($v ?: new static());
    }

    /**
     * Determines if the instance is less (before) or equal to another
     *
     * @param Verta $v
     *
     * @see lte()
     *
     * @return bool
     */
    public function lessThanOrEqualTo(Verta $v = null)
    {
        return $this->lte($v);
    }

    /**
     * Determines if the instance is between two others
     *
     * @param Verta $v1
     * @param Verta $v2
     * @param bool   $equal Indicates if a > and < comparison should be used or <= or >=
     *
     * @return bool
     */
    public function between(Verta $v1, Verta $v2, $equal = true)
    {
        if ($v1->gt($v2)) {
            $temp = $v1;
            $v1 = $v2;
            $v2 = $temp;
        }

        if ($equal) {
            return $this->gte($v1) && $this->lte($v2);
        }

        return $this->gt($v1) && $this->lt($v2);
    }

    /**
     * Get the closest date from the instance.
     *
     * @param Verta $v1
     * @param Verta $v2
     *
     * @return static
     */
    public function closest(Verta $v1, Verta $v2)
    {
        return $this->diffSeconds($v1) < $this->diffSeconds($v2) ? $v1 : $v2;
    }

    /**
     * Get the farthest date from the instance.
     *
     * @param Verta $v1
     * @param Verta $v2
     *
     * @return static
     */
    public function farthest(Verta $v1, Verta $v2)
    {
        return $this->diffSeconds($v1) > $this->diffSeconds($v2) ? $v1 : $v2;
    }

    /**
     * Get the minimum instance between a given instance (default now) and the current instance.
     *
     * @param Verta|null $v
     *
     * @return static
     */
    public function min(Verta $v = null)
    {
        $v = $v ?: static::now($this->getTimezone());

        return $this->lt($v) ? $this : $v;
    }

    /**
     * Get the minimum instance between a given instance (default now) and the current instance.
     *
     * @param Verta|null $v
     *
     * @see min()
     *
     * @return static
     */
    public function minimum(Verta $v = null)
    {
        return $this->min($v);
    }

    /**
     * Get the maximum instance between a given instance (default now) and the current instance.
     *
     * @param Verta|null $v
     *
     * @return static
     */
    public function max(Verta $v = null)
    {
        $v = $v ?: static::now($this->getTimezone());

        return $this->gt($v) ? $this : $v;
    }

    /**
     * Get the maximum instance between a given instance (default now) and the current instance.
     *
     * @param Verta|null $v
     *
     * @see max()
     *
     * @return static
     */
    public function maximum(Verta $v = null)
    {
        return $this->max($v);
    }

    /**
     * Determines if the instance is a weekday
     *
     * @return bool
     */
    public function isWeekday()
    {
        return !$this->isWeekend();
    }

    /**
     * Determines if the instance is a weekend day
     *
     * @return bool
     */
    public function isWeekend()
    {
        return in_array($this->dayOfWeek, static::$weekendDays);
    }

    /**
     * Determines if the instance is yesterday
     *
     * @return bool
     */
    public function isYesterday()
    {
        return $this->formatDate() === static::yesterday($this->getTimezone())->formatDate();
    }

    /**
     * Determines if the instance is today
     *
     * @return bool
     */
    public function isToday()
    {
        return $this->formatDate() === static::now($this->getTimezone())->formatDate();
    }

    /**
     * Determines if the instance is tomorrow
     *
     * @return bool
     */
    public function isTomorrow()
    {
        return $this->formatDate() === static::tomorrow($this->getTimezone())->formatDate();
    }

    /**
     * Determines if the instance is within the next week
     *
     * @return bool
     */
    public function isNextWeek()
    {
        return $this->weekOfYear === static::now($this->getTimezone())->addWeek()->weekOfYear;
    }

    /**
     * Determines if the instance is within the last week
     *
     * @return bool
     */
    public function isLastWeek()
    {
        return $this->weekOfYear === static::now($this->getTimezone())->subWeek()->weekOfYear;
    }

    /**
     * Determines if the instance is within the next month
     *
     * @return bool
     */
    public function isNextMonth()
    {
        return $this->month === static::now($this->getTimezone())->addMonth()->month;
    }

    /**
     * Determines if the instance is within the last month
     *
     * @return bool
     */
    public function isLastMonth()
    {
        return $this->month === static::now($this->getTimezone())->subMonth()->month;
    }

    /**
     * Determines if the instance is within next year
     *
     * @return bool
     */
    public function isNextYear()
    {
        return $this->year === static::now($this->getTimezone())->addYear()->year;
    }

    /**
     * Determines if the instance is within the previous year
     *
     * @return bool
     */
    public function isLastYear()
    {
        return $this->year === static::now($this->getTimezone())->subYear()->year;
    }

    /**
     * Determines if the instance is in the future, ie. greater (after) than now
     *
     * @return bool
     */
    public function isFuture()
    {
        return $this->gt(static::now($this->getTimezone()));
    }

    /**
     * Determines if the instance is in the past, ie. less (before) than now
     *
     * @return bool
     */
    public function isPast()
    {
        return $this->lt(static::now($this->getTimezone()));
    }

    /**
     * Compares the formatted values of the two dates.
     *
     * @param string              $format The date formats to compare.
     * @param Verta|null $v     The instance to compare with or null to use current day.
     *
     * @return bool
     */
    public function isSameAs($format, Verta $v = null)
    {
        $v = $v ?: static::now($this->timezone);

        return $this->format($format) === $v->format($format);
    }

    /**
     * Determines if the instance is in the current year
     *
     * @return bool
     */
    public function isCurrentYear()
    {
        return $this->isSameYear();
    }

    /**
     * Checks if the passed in date is in the same year as the instance year.
     *
     * @param Verta|null $v The instance to compare with or null to use current day.
     *
     * @return bool
     */
    public function isSameYear(Verta $v = null)
    {
        return $this->isSameAs('Y', $v);
    }

    /**
     * Determines if the instance is in the current month
     *
     * @return bool
     */
    public function isCurrentMonth()
    {
        return $this->isSameMonth();
    }

    /**
     * Checks if the passed in date is in the same month as the instance month (and year if needed).
     *
     * @param Verta|null $v         The instance to compare with or null to use current day.
     * @param bool                $ofSameYear Check if it is the same month in the same year.
     *
     * @return bool
     */
    public function isSameMonth(Verta $v = null, $ofSameYear = false)
    {
        $format = $ofSameYear ? 'Y-m' : 'm';

        return $this->isSameAs($format, $v);
    }

    /**
     * Checks if the passed in date is the same day as the instance current day.
     *
     * @param Verta $v
     *
     * @return bool
     */
    public function isSameDay(Verta $v)
    {
        return $this->formatDate() === $v->formatDate();
    }

    /**
     * Check if its the birthday. Compares the date/month values of the two dates.
     *
     * @param Verta|null $dt The instance to compare with or null to use current day.
     *
     * @return bool
     */
    public function isBirthday(Verta $v = null)
    {
        return $this->isSameAs('md', $v);
    }

    /**
     * Checks if this day is a Saturday.
     *
     * @return bool
     */
    public function isSaturday()
    {
        return $this->dayOfWeek === static::SATURDAY;
    }

    /**
     * Checks if this day is a Sunday.
     *
     * @return bool
     */
    public function isSunday()
    {
        return $this->dayOfWeek === static::SUNDAY;
    }

    /**
     * Checks if this day is a Monday.
     *
     * @return bool
     */
    public function isMonday()
    {
        return $this->dayOfWeek === static::MONDAY;
    }

    /**
     * Checks if this day is a Tuesday.
     *
     * @return bool
     */
    public function isTuesday()
    {
        return $this->dayOfWeek === static::TUESDAY;
    }

    /**
     * Checks if this day is a Wednesday.
     *
     * @return bool
     */
    public function isWednesday()
    {
        return $this->dayOfWeek === static::WEDNESDAY;
    }

    /**
     * Checks if this day is a Thursday.
     *
     * @return bool
     */
    public function isThursday()
    {
        return $this->dayOfWeek === static::THURSDAY;
    }

    /**
     * Checks if this day is a Friday.
     *
     * @return bool
     */
    public function isFriday()
    {
        return $this->dayOfWeek === static::FRIDAY;
    }

    /*****************************  MODIFY ****************************/

    /**
     * Add years to the instance. Positive $value travel forward while
     * negative $value travel into the past.
     *
     * @param int $value
     *
     * @return static
     */
    public function addYears($value)
    {
        return $this->modify((int) $value.' year');
    }

    /**
     * Add a year to the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function addYear($value = 1)
    {
        return $this->addYears($value);
    }

    /**
     * Remove years from the instance.
     *
     * @param int $value
     *
     * @return static
     */
    public function subYears($value)
    {
        return $this->addYears(-1 * $value)->modify('-1 day');
    }

    /**
     * Remove a year from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subYear($value = 1)
    {
        return $this->subYears($value);
    }

    /**
     * Add months to the instance. Positive $value travels forward while
     * negative $value travels into the past.
     *
     * @param int $value
     *
     * @return static
     */
    public function addMonths($value)
    {
        list($year, $month, $day, $hour, $minute, $second) = explode('-', $this->format('Y-m-d-H-i-s'));
        $month += $value;
        if ($month > 12) {
            $year += intval($month / 12);
            $month = $month % 12;
        }
        elseif ($month < 1) {
            $year += intval($month / 12) - 1;
            $month = 12 + ($month % 12);
        }
        if($month == 0) {
            $year--;
            $month = 12;
        }
        if (($month > 6 && $month < 12 && $day == 31)) {
            $day--;
        }
        else {
            if ($month == 12 && ($day == 30 || $day == 31)) {
                $day = self::isLeapYear($year) ? 30 : 29;
            }
        }
        return self::createJalali($year, $month, $day, $hour, $minute, $second, $this->getTimeZone());
    }

    /**
     * Add a month to the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function addMonth($value = 1)
    {
        return $this->addMonths($value);
    }

    /**
     * Remove a month from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subMonth($value = 1)
    {
        return $this->subMonths($value);
    }

    /**
     * Remove months from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subMonths($value)
    {
        return $this->addMonths(-1 * $value);
    }

    /**
     * Add days to the instance. Positive $value travels forward while
     * negative $value travels into the past.
     *
     * @param int $value
     *
     * @return static
     */
    public function addDays($value)
    {
        return $this->modify((int) $value.' day');
    }

    /**
     * Add a day to the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function addDay($value = 1)
    {
        return $this->addDays($value);
    }

    /**
     * Remove a day from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subDay($value = 1)
    {
        return $this->subDays($value);
    }

    /**
     * Remove days from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subDays($value)
    {
        return $this->addDays(-1 * $value);
    }

    /**
     * Add weeks to the instance. Positive $value travels forward while
     * negative $value travels into the past.
     *
     * @param int $value
     *
     * @return static
     */
    public function addWeeks($value)
    {
        return $this->modify((int) $value.' week');
    }

    /**
     * Add a week to the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function addWeek($value = 1)
    {
        return $this->addWeeks($value);
    }

    /**
     * Remove a week from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subWeek($value = 1)
    {
        return $this->subWeeks($value);
    }

    /**
     * Remove weeks to the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subWeeks($value)
    {
        return $this->addWeeks(-1 * $value);
    }

    /**
     * Add hours to the instance. Positive $value travels forward while
     * negative $value travels into the past.
     *
     * @param int $value
     *
     * @return static
     */
    public function addHours($value)
    {
        return $this->modify((int) $value.' hour');
    }

    /**
     * Add an hour to the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function addHour($value = 1)
    {
        return $this->addHours($value);
    }

    /**
     * Remove an hour from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subHour($value = 1)
    {
        return $this->subHours($value);
    }

    /**
     * Remove hours from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subHours($value)
    {
        return $this->addHours(-1 * $value);
    }

    /**
     * Add minutes to the instance. Positive $value travels forward while
     * negative $value travels into the past.
     *
     * @param int $value
     *
     * @return static
     */
    public function addMinutes($value)
    {
        return $this->modify((int) $value.' minute');
    }

    /**
     * Add a minute to the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function addMinute($value = 1)
    {
        return $this->addMinutes($value);
    }

    /**
     * Remove a minute from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subMinute($value = 1)
    {
        return $this->subMinutes($value);
    }

    /**
     * Remove minutes from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subMinutes($value)
    {
        return $this->addMinutes(-1 * $value);
    }

    /**
     * Add seconds to the instance. Positive $value travels forward while
     * negative $value travels into the past.
     *
     * @param int $value
     *
     * @return static
     */
    public function addSeconds($value)
    {
        return $this->modify((int) $value.' second');
    }

    /**
     * Add a second to the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function addSecond($value = 1)
    {
        return $this->addSeconds($value);
    }

    /**
     * Remove a second from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subSecond($value = 1)
    {
        return $this->subSeconds($value);
    }

    /**
     * Remove seconds from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subSeconds($value)
    {
        return $this->addSeconds(-1 * $value);
    }

    /**
     * Resets the time to 00:00:00
     *
     * @return static
     */
    public function startDay()
    {
        return $this->setTime(0, 0, 0);
    }

    /**
     * Resets the time to 23:59:59
     *
     * @return static
     */
    public function endDay()
    {
        return $this->setTime(23, 59, 59);
    }

    /**
     * Resets the date to the first day of week (defined in $weekStartsAt) and the time to 00:00:00
     *
     * @return static
     */
    public function startWeek()
    {
        while ($this->dayOfWeek !== static::$weekStartsAt) {
            $this->subDay();
        }

        return $this->startDay();
    }

    /**
     * Resets the date to end of week (defined in $weekEndsAt) and time to 23:59:59
     *
     * @return static
     */
    public function endWeek()
    {
        while ($this->dayOfWeek !== static::$weekEndsAt) {
            $this->addDay();
        }

        return $this->endDay();
    }

    /**
     * Resets the date to the first day of the month and the time to 00:00:00
     *
     * @return static
     */
    public function startMonth()
    {
        return $this->setDateTime($this->year, $this->month, 1, 0, 0, 0);
    }

    /**
     * Resets the date to end of the month and time to 23:59:59
     *
     * @return static
     */
    public function endMonth()
    {
        return $this->setDateTime($this->year, $this->month, $this->daysInMonth, 23, 59, 59);
    }

    /**
     * Resets the date to the first day of the quarter and the time to 00:00:00
     *
     * @return static
     */
    public function startQuarter()
    {
        $month = ($this->quarter - 1) * static::MONTHS_PER_QUARTER + 1;

        return $this->setDateTime($this->year, $month, 1, 0, 0, 0);
    }

    /**
     * Resets the date to end of the quarter and time to 23:59:59
     *
     * @return static
     */
    public function endQuarter()
    {
        return $this->startQuarter()->addMonths(static::MONTHS_PER_QUARTER - 1)->endMonth();
    }

    /**
     * Resets the date to the first day of the year and the time to 00:00:00
     *
     * @return static
     */
    public function startYear()
    {
        return $this->setDateTime($this->year, 1, 1, 0, 0, 0);
    }

    /**
     * Resets the date to end of the year and time to 23:59:59
     *
     * @return static
     */
    public function endYear()
    {
        $day = $this->format('L') ? 30 : 29;

        return $this->setDateTime($this->year, 12, $day, 23, 59, 59);
    }

    /*****************************  TRANSFORMATION  ****************************/

    /**
     * gregorian to jalali convertion
     *
     * @param int $g_y
     * @param int $g_m
     * @param int $g_d
     * @return array
     */
    public static function getJalali($g_y, $g_m, $g_d) {
        $gy = $g_y - 1600;
        $gm = $g_m - 1;
        $g_day_no = (365 * $gy + static::div($gy + 3, 4) - static::div($gy + 99, 100) + static::div($gy + 399, 400));
        for ($i = 0; $i < $gm; ++$i) {
            $g_day_no += static::$daysMonthGregorian[$i];
        }
        if ($gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0)))
            # leap and after Feb
            $g_day_no ++;
        $g_day_no += $g_d - 1;
        $j_day_no = $g_day_no - 79;
        $j_np = static::div($j_day_no, 12053); # 12053 = (365 * 33 + 32 / 4)
        $j_day_no = $j_day_no % 12053;
        $jy = (979 + 33 * $j_np + 4 * static::div($j_day_no, 1461)); # 1461 = (365 * 4 + 4 / 4)
        $j_day_no %= 1461;
        if ($j_day_no >= 366) {
            $jy += static::div($j_day_no - 1, 365);
            $j_day_no = ($j_day_no - 1) % 365;
        }
        for ($i = 0; ($i < 11 && $j_day_no >= static::$daysMonthJalali[$i]); ++$i) {
            $j_day_no -= static::$daysMonthJalali[$i];
        }
        return array($jy, $i + 1, $j_day_no + 1);
    }

    /**
     * jalali to gregorian convertion
     *
     * @param int $j_y
     * @param int $j_m
     * @param int $j_d
     * @return array
     */
    public static function getGregorian($j_y, $j_m, $j_d) {
        $jy = $j_y - 979;
        $jm = $j_m - 1;
        $j_day_no = (365 * $jy + static::div($jy, 33) * 8 + static::div($jy % 33 + 3, 4));
        for ($i = 0; $i < $jm; ++$i) {
            $j_day_no += static::$daysMonthJalali[$i];
        }
        $j_day_no += $j_d - 1;
        $g_day_no = $j_day_no + 79;
        $gy = (1600 + 400 * static::div($g_day_no, 146097)); # 146097 = (365 * 400 + 400 / 4 - 400 / 100 + 400 / 400)
        $g_day_no = $g_day_no % 146097;
        $leap = 1;
        if ($g_day_no >= 36525) { # 36525 = (365 * 100 + 100 / 4)
            $g_day_no --;
            $gy += (100 * static::div($g_day_no, 36524)); # 36524 = (365 * 100 + 100 / 4 - 100 / 100)
            $g_day_no = $g_day_no % 36524;
            if ($g_day_no >= 365) {
                $g_day_no ++;
            } else {
                $leap = 0;
            }
        }
        $gy += (4 * static::div($g_day_no, 1461)); # 1461 = (365 * 4 + 4 / 4)
        $g_day_no %= 1461;
        if ($g_day_no >= 366) {
            $leap = 0;
            $g_day_no --;
            $gy += static::div($g_day_no, 365);
            $g_day_no = ($g_day_no % 365);
        }
        for ($i = 0; $g_day_no >= (static::$daysMonthGregorian[$i] + ($i == 1 && $leap)); $i ++) {
            $g_day_no -= (static::$daysMonthGregorian[$i] + ($i == 1 && $leap));
        }
        return array($gy, $i + 1, $g_day_no + 1);
    }

    /**
     * integer division
     *
     * @param int $a
     * @param int $b
     * @return int
     */
    private static function div($a, $b) {
        return ~~($a / $b);
    }
}
