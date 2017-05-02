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
use Closure;
use DateTime;
use DateTimeZone;
use DatePeriod;
use InvalidArgumentException;
use Exception;

    
    /*********************************  CONFIG  *********************************/
	/**
     * set Default timezone
     */
	date_default_timezone_set('Asia/Tehran');

class Verta extends DateTime {

    /*****************************  STATCT VARIABLE  ****************************/
	
	/**
     * The day constants
     */
    const SATURDAY 		            = 0;
    const SUNDAY 		            = 1;
    const MONDAY 		            = 2;
    const TUESDAY		            = 3;
    const WEDNESDAY		            = 4;
    const THURSDAY 		            = 5;
    const FRIDAY 		            = 6;

	/**
     * Number unit in date
     */
    const YEARS_PER_CENTURY		    = 100;
    const YEARS_PER_DECADE		    = 10;
    const MONTHS_PER_YEAR		    = 12;
    const WEEKS_PER_YEAR		    = 52;
    const WEEKS_PER_MONTH		    = 4.35;
    const DAYS_PER_WEEK			    = 7;
    const HOURS_PER_DAY			    = 24;
    const MINUTES_PER_HOUR		    = 60;
    const SECONDS_PER_MINUTE        = 60;

    /**
     * Word use in format datetime.
    */
    const DEFAULT_STRING_FORMAT  = 'Y-m-d H:i:s';

    /**
     * Format to use for __toString.
     *
     * @var string
     */
    protected static $stringFormat = self::DEFAULT_STRING_FORMAT;  

    /**
     * @var array
     */
    protected static $formats = array(
        'datetime'      => 'Y-m-d H:i:s',
        'date'          => 'Y-m-d',
        'time'          => 'H:i:s',
    );

    /**
     * Default format to use for __toString method when type juggling occurs.
     */
    const AM                        = 'ق.ظ';
    const PM                        = 'ب.ظ';
    const ANTE_MERIDIEM             = 'قبل از ظهر';
    const POST_MERIDIEM             = 'بعد از ظهر';
    const NUMBER_TH                 = ' ام';
    const PRE                       = 'پیش';
    const POST                      = 'بعد';

    /**
     * Number persian in convertion
     */
    const PERSIAN_ZERO              = '۰';
    const PERSIAN_ONE               = '۱';
    const PERSIAN_TOW               = '۲';
    const PERSIAN_THREE             = '۳';
    const PERSIAN_FOUR              = '۴';
    const PERSIAN_FIVE              = '۵';
    const PERSIAN_SIX               = '۶';
    const PERSIAN_SEVEN             = '۷';
    const PERSIAN_EIGHT             = '۸';
    const PERSIAN_NINE              = '۹';

    /**
     * Number english in convertion
     */
    const ENGLISH_ZERO              = '0';
    const ENGLISH_ONE               = '1';
    const ENGLISH_TOW               = '2';
    const ENGLISH_THREE             = '3';
    const ENGLISH_FOUR              = '4';
    const ENGLISH_FIVE              = '5';
    const ENGLISH_SIX               = '6';
    const ENGLISH_SEVEN             = '7';
    const ENGLISH_EIGHT             = '8';
    const ENGLISH_NINE              = '9';

    /**
     * number day in months gregorian
     *
     * @var array
     */
    protected static $daysMonthGregorian = array(
    	31, // January
    	28, // February
    	31, // March
    	30, // April
    	31, // May
    	30, // June
    	31, // July
    	31, // August
    	30, // September
    	31, // October
    	30, // November
    	31, // December
    );
	

    /**
     * number day in month jalali
     *
     * @var array
     */
	protected static $daysMonthJalali = array(
		31, // فرودین
		31, // اردیبهشت
		31, // خرداد
		31, // تیر
		31, // مرداد
		31, // شهریور
		30, // مهر
		30, // آبان
		30, // آذر
		30, // دی
		30, // بهمن
		29, // اسفند
	);

    /**
     * month name jalali
     *
     * @var array
     */
	protected static $monthYear = array(
		'فرودین', 	// 1		
		'اردیبهشت',	// 2	
		'خرداد', 	// 3		
		'تیر', 		// 4		
		'مرداد', 	// 5		
		'شهریور', 	// 6		
		'مهر', 		// 7		
		'آبان', 	// 8 		
		'آذر', 		// 9		
		'دی', 		// 10		
		'بهمن', 	// 11 		
		'اسفند', 	// 12		
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
     * persian number.
     *
     * @var array
     */
    protected static $persianNumber = array(
        self::PERSIAN_ZERO,
        self::PERSIAN_ONE,
        self::PERSIAN_TOW,
        self::PERSIAN_THREE,
        self::PERSIAN_FOUR,
        self::PERSIAN_FIVE,
        self::PERSIAN_SIX,
        self::PERSIAN_SEVEN,
        self::PERSIAN_EIGHT,
        self::PERSIAN_NINE,
    );

    /**
     * english number.
     *
     * @var array
     */
    protected static $englishNumber = array(
        self::ENGLISH_ZERO,
        self::ENGLISH_ONE,
        self::ENGLISH_TOW,
        self::ENGLISH_THREE,
        self::ENGLISH_FOUR,
        self::ENGLISH_FIVE,
        self::ENGLISH_SIX,
        self::ENGLISH_SEVEN,
        self::ENGLISH_EIGHT,
        self::ENGLISH_NINE,
    );

    /*****************************  CONSTRUCT  ****************************/

    /**
     * create object of Jalali
     *
     * @param timestamp $timestamp [optional]
     * @param bool $timezone [optional]
     */
	public function __construct($datetime = null, $timezone = null) {

		if ($datetime === null) {
            $instance = time();
        }
        elseif (is_string($datetime)){
            $object = date_create($datetime);
            if ($object === false) {
                throw new InvalidArgumentException('Unknown datetime ('.$datetime.')');
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
	        throw new \InvalidArgumentException('Unknown datetime ('.$datetime.')');
		}
        $timezone = static::createTimeZone($timezone);
		parent::__construct(date('Y-m-d H:i:s.u', $instance), $timezone);
	}

    /**
     * Create a Verta now datetime
     *
     *
     * @return static
     */
    public static function now() { 
        return new static();
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
     * Create a DateTime instance from Verta
     *
     * @return DateTime $datetime
     */
    public function DateTime() { 
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
        $parse = date_parse($datetime);

        if($parse['error_count'] == 0){
            list($year, $month, $day) = self::getGregorian($parse['year'], $parse['month'], $parse['day']);
            list( $hour,$minute, $second) = array($parse['hour'], $parse['minute'], $parse['second']);

            $timezone = self::createTimeZone($timezone);
            $datetime = new DateTime(sprintf('%04s-%02s-%02s %02s:%02s:%02s', $year, $month, $day, $hour, $minute, $second), $timezone);
            return new static($datetime);
        }
        else{
            throw new \InvalidArgumentException('Unknown datetime ('.$datetime.')');
        }
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

    public static function create($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $timezone = null)
    {
        $now = static::instance(null, $timezone)->format('Y-n-j-G-i-s');
        $defaults = array_combine(array('year', 'month', 'day', 'hour', 'minute', 'second'), explode('-', $now));

        $year   = $year   === null ? intval($defaults['year'])   : $year;
        $month  = $month  === null ? intval($defaults['month'])  : $month;
        $day    = $day    === null ? intval($defaults['day'])    : $day;
        $hour   = $hour   === null ? intval($defaults['hour'])   : $hour;
        $minute = $minute === null ? intval($defaults['minute']) : $minute;
        $second = $second === null ? intval($defaults['second']) : $second;

        if (!static::isValideDate($year, $month, $day) || !static::isValideTime($hour, $minute, $second)) {
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
    public static function createDate($year = null, $month = null, $day = null, $timezone = null)
    {
        return static::create($year, $month, $day, null, null, null, $timezone);
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
            return new DateTimeZone('Asia/Tehran');
        }
        if ($timezone instanceof DateTimeZone) {
            return $timezone;
        }
        $object = @timezone_open(strval($timezone));
        if ($object === false) {
            throw new InvalidArgumentException('Unknown timezone ('.$timezone.')');
        }

        return $object;
    }

	/*****************************  STRING FORMATED  ****************************/


    /**
     * Reset the format used to the default when type juggling a Carbon instance to a string
     */
    public static function resetStringFormat()
    {
        static::setStringFormat(static::DEFAULT_STRING_FORMAT);
    }

    /**
     * Set the default format used when type juggling a Carbon instance to a string
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

	    while ($i < $lenghFormat) {
	        $par = $format{$i};
	        if ($par == '\\') {
	            $result .= $format{ ++$i};
	            $i ++;
	            continue;
	        }
	        switch ($par) {
	            # Day
	            case 'd':
	                $result .= sprintf('%02s', $pDay);
	                break;

	            case 'D':
	                $result .= substr(static::$dayWeek[$pWeek], 0, 2);
	                break;

	            case 'j':
	                $result .= $pDay;
	                break;

	            case 'l':
	                $result .= static::$dayWeek[$pWeek];
	                break;

	            case 'N':
	                $result .= $pWeek + 1;
	                break;

	            case 'w':
	                $result .= $pWeek;
	                break;

	            case 'z':
	                $result .= $this->daysYear($pMonth, $pDay);
	                break;

	            case 'S':
	                $result .= self::NUMBER_TH;
	                break;

	            # Week
	            case 'W':
	                $result .= ceil($this->daysYear($pMonth, $pDay) / 7);
	                break;

	            # Month
	            case 'F':
	                $result .= static::$monthYear[$pMonth-1];
	                break;

	            case 'm':
	                $result .= sprintf('%02s', $pMonth);
	                break;

	            case 'M':
	                $result .= substr(static::$monthYear[$pMonth-1], 0, 6);
	                break;

	            case 'n':
	                $result .= $pMonth;
	                break;

	            case 't':
	                $result .= $this->daysMonthJalali($pYear,$pMonth);
	                break;

	            # Years
	            case 'L':
	                $result .= intval($this->isLeapYear($pYear));
	                break;

	            case 'Y':
	            case 'o':
	                $result .= $pYear;
	                break;

	            case 'y':
	                $result .= substr($pYear, 2);
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
	            # Timezone
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
	                $result .= ($pYear . '-' . $pMonth . '-' . $pDay . ' ' . date('H:i:s P', $timestamp));
	                break;

	            case 'r':
	                $result .= (substr(static::$dayWeek[$pWeek], 0, 2) . '، ' . $pDay . ' ' . substr(static::$monthYear[$pMonth], 0, 6) . ' ' . $pYear . ' ' . date('H:i:s P', $timestamp));
	                break;

	            case 'U':
	                $result .= $timestamp;
	                break;

	            default:
	                $result .= $par;
	        }
	        $i ++;
	    }

	    return $result;
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

        //Change Strftime format to Date format
        $format = str_replace($str_format_code, $date_format_code, $format);

        //Convert to date
        return $this->date($format);
    }

    /**
     * The format of the outputted date string (jalali equivalent of php strftime() function)
     *
     * @param $format
     * @return string
     */
    public function format($format) {

        if (in_array($format, array_keys(self::$formats))) {
            $format = self::$formats[$format];
        }
        return $this->strftime($format);
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
    public function formatPersianDatetime()
    {
        return $this->format('Y/n/j H:i:s');
    }

    /**
     * Format the instance as date
     *
     * @return string
     */
    public function formatPersianDate()
    {
        return $this->format('Y/n/j');
    }


    /**
     * get difference to  now
     *
     * @return string
     */
    public function diffNow()
    {
        $now = time();

        // get difference
        $difference = $now - $this->getTimestamp();

        $negative = true;
        // set descriptor
        if ($difference < 0) {
            $difference = abs($difference); // absolute value
            $negative = false;
        }

        // do math
        for ($j = 0; $difference >= static::$unitNumber[$j] and $j < count(static::$unitNumber) - 1; $j++) {
            $difference /= static::$unitNumber[$j];
        }

        // round difference
        $difference = intval(round($difference));
        $timebound = ($negative ? self::PRE : self::POST);

        return sprintf('%s %s %s', $difference, static::$unitName[$j], $timebound);
    }

    /**
     * Convert english numbers to persian numbers
     *
     * @param string $string
     * @return string
     */
    public static function persianNumbers($string)
    {
        return str_replace(self::$englishNumber, self::$persianNumber, $string);
    }

    /*****************************  COMPERTION  ****************************/

	

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
    public static function isValideDate($year, $month, $day) {
        return $year >= 1 && $year <= 32766
        && $month >= 1 && $month <= 12
        && $day >= 1 && $day <= static::daysMonthJalali($year, $month);
    }


    /**
     * validate a time
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @return bool
     */
    public static function isValideTime($hour, $minute, $second) {
        return $hour >= 0 && $hour <= 24
        && $minute >= 0 && $minute <= 59
        && $second >= 0 && $second <= 59;
    }


    /*****************************  CALCULATION ****************************/

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




    /*****************************  CONVERTION  ****************************/

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

    /*****************************  HELPER  ****************************/


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

	/**
	 * return day number from first day of year
	 *
	 * @param int $month
	 * @param int $day
	 * @return type
	 * @since 5.0.0
	 */
	public function daysYear($month, $day) {
	    $days = 0;
	    for ($i = 0; $i < $month; $i ++) {
	        $days += static::$daysMonthJalali[$i];
	    }
	    return ($days + $day);
	}

	/**
	 * return last day of month
	 *
	 * @param int $year
	 * @param int $month
	 * @return int
	 */
	public static function daysMonthJalali($year,$month) {
	    if(static::isLeapYear($year) && ($month == 12))
	        return 30;
	    $month = intval($month);
	    return static::$daysMonthJalali[$month-1];
	}

}