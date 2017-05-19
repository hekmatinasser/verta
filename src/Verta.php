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
    const DEFAULT_STRING_FORMAT     = 'Y-m-d H:i:s';

    /**
     * Format to use for __toString.
     *
     * @var string
     */
    protected static $stringFormat  = self::DEFAULT_STRING_FORMAT;  

    /**
     * @var array
     */
    protected static $formats = array(
        'datetime'                  => 'Y-m-d H:i:s',
        'date'                      => 'Y-m-d',
        'time'                      => 'H:i:s',
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
     * Curency use in number to word.
    */
    const RIAL =  'ریال';
    const TOMAN =  'تومان';

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
		'فرودین',
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
     * persian number.
     *
     * @var array
     */
    protected static $persianNumber = array(
        '۰',
        '۱',
        '۲',
        '۳',
        '۴',
        '۵',
        '۶',
        '۷',
        '۸',
        '۹',
    );

    /**
     * english number.
     *
     * @var array
     */
    protected static $englishNumber = array(
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
    );

    protected static $number_word = array(
        'fa' => array(
            'd1' => array(
                0 => 'صفر',
                1 => 'یک',
                2 => 'دو',
                3 => 'سه',
                4 => 'چهار',
                5 => 'پنج',
                6 => 'شش',
                7 => 'هفت',
                8 => 'هشت',
                9 => 'نه',
            ),
            'd2-1' => array(
                1 => 'یازده',
                2 => 'دوازده',
                3 => 'سیزده',
                4 => 'چهارده',
                5 => 'پانزده',
                6 => 'شانزده',
                7 => 'هفده',
                8 => 'هجده',
                9 => 'نوزده',
            ),
            'd2-2' => array(
                1 => 'ده',
                2 => 'بیست',
                3 => 'سی',
                4 => 'چهل',
                5 => 'پنجاه',
                6 => 'شصت',
                7 => 'هفتاد',
                8 => 'هشتاد',
                9 => 'نود'
            ),
            'd3' => array(
                1 => 'صد',
                2 => 'دویست',
                3 => 'سیصد',
                4 => 'چهارصد',
                5 => 'پانصد',
                6 => 'ششصد',
                7 => 'هفتصد',
                8 => 'هشتصد',
                9 => 'نهصد',
            ),
            'step' => array(
                1 => 'هزار',
                2 => 'میلیون',
                3 => 'میلیارد',
                4 => 'بیلیون',
                5 => 'تریلیون',
                6 => 'کادریلیون',
                7 => 'کوینتریلیون',
                8 => 'سکستریلیون',
                9 => 'سپتریلیون',
                10 => 'اکتریلیون',
                11 => 'نونیلیون',
                12 => 'دسیلیون',
            ),
            'and' => 'و',
        ),
        'en' => array(
            'd1' => array(
                0 => 'zero',
                1 => 'one',
                2 => 'two',
                3 => 'three',
                4 => 'four',
                5 => 'five',
                6 => 'six',
                7 => 'seven',
                8 => 'eight',
                9 => 'nine',
            ),
            'd2-1' => array(
                1 => 'eleven',
                2 => 'twelve',
                3 => 'thirteen',
                4 => 'fourteen',
                5 => 'fifteen',
                6 => 'sixteen',
                7 => 'seventeen',
                8 => 'eighteen',
                9 => 'nineteen',
            ),
            'd2-2' => array(
                1 => 'ten',
                2 => 'twenty',
                3 => 'thirty',
                4 => 'forty',
                5 => 'fifty',
                6 => 'sixty',
                7 => 'seventy',
                8 => 'eighty',
                9 => 'ninety'
            ),
            'd3' => array(
                1 => 'one hundred',
                2 => 'two hundred',
                3 => 'three hundred',
                4 => 'four hundred',
                5 => 'five hundred',
                6 => 'six hundred',
                7 => 'seven hundred',
                8 => 'eight hundred',
                9 => 'nine hundred',
            ),
            'step' => array(
                1 => 'thousand',
                2 => 'million',
                3 => 'milliard',
                4 => 'billion',
                5 => 'trillion',
                6 => 'quadrillion',
                7 => 'quintillion',
                8 => 'sextillion',
                9 => 'septillion',
                10 => 'octillion',
                11 => 'nonillion',
                12 => 'decillion',
            ),
            'and' => 'and',
        ),
    );
    protected static $digit1 = array(
        0 => 'صفر',
        1 => 'یک',
        2 => 'دو',
        3 => 'سه',
        4 => 'چهار',
        5 => 'پنج',
        6 => 'شش',
        7 => 'هفت',
        8 => 'هشت',
        9 => 'نه',
    );
    protected static $digit1_5 = array(
        1 => 'یازده',
        2 => 'دوازده',
        3 => 'سیزده',
        4 => 'چهارده',
        5 => 'پانزده',
        6 => 'شانزده',
        7 => 'هفده',
        8 => 'هجده',
        9 => 'نوزده',
    );
    protected static $digit2 = array(
        1 => 'ده',
        2 => 'بیست',
        3 => 'سی',
        4 => 'چهل',
        5 => 'پنجاه',
        6 => 'شصت',
        7 => 'هفتاد',
        8 => 'هشتاد',
        9 => 'نود'
    );
    protected static $digit3 = array(
        1 => 'صد',
        2 => 'دویست',
        3 => 'سیصد',
        4 => 'چهارصد',
        5 => 'پانصد',
        6 => 'ششصد',
        7 => 'هفتصد',
        8 => 'هشتصد',
        9 => 'نهصد',
    );
    protected static $steps = array(
        1 => 'هزار',
        2 => 'میلیون',
        3 => 'میلیارد',
        4 => 'بیلیون',
        5 => 'تریلیون',
        6 => 'کادریلیون',
        7 => 'کوینتریلیون',
        8 => 'سکستریلیون',
        9 => 'سپتریلیون',
        10 => 'اکتریلیون',
        11 => 'نونیلیون',
        12 => 'دسیلیون',
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
        if ($month < 1) {
            $year += intval($month / 12) - 1;
            $month = 12 + ($month % 12);
        }
        if ($value > 0) {
            if ($month > 6 && $day == 31) {
                $day--;
            }
            if ($month == 12 && !self::isLeapYear($year)) {
                $day--;
            }
        }
        else {
            if ($month == 12 && $day == 31) {
                if (self::isLeapYear($year)) {
                    $day = 30;
                }
                else {
                    $day = 29;
                }
            }
        }
        return self::create($year, $month, $day, $hour, $minute, $second, $this->getTimeZone());
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

    /*****************************  HELPER  ****************************/


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

    /**
     * format number for change to word
     *
     * @param string $number
     * @param int $decimal_precision
     * @param string $decimals_separator
     * @param string $thousands_separator
     * @return string
     */
    static function number_format($number, $decimal_precision = 0, $decimals_separator = '.', $thousands_separator = ',') {
        $number = explode('.', str_replace(' ', '', $number));
        $number[0] = str_split(strrev($number[0]), 3);
        $total_segments = count($number[0]);
        for ($i = 0; $i < $total_segments; $i++) {
            $number[0][$i] = strrev($number[0][$i]);
        }
        $number[0] = implode($thousands_separator, array_reverse($number[0]));
        if (!empty($number[1])) {
           $number[1] = round($number[1], $decimal_precision);
        }
        return implode($decimals_separator, $number);
    }

    /**
     * group number to word
     *
     * @param array $group
     * @param string $lang
     * @return array
     */
    protected static function groupToWords($group, $lang) {
        $d3 = floor($group / 100);
        $d2 = floor(($group - $d3 * 100) / 10);
        $d1 = $group - $d3 * 100 - $d2 * 10;

        $group_array = array();

        if ($d3 != 0) {
            $group_array[] = static::$number_word[$lang]['d3'][$d3];
        }

        if ($d2 == 1 && $d1 != 0) { // 11-19
            $group_array[] = static::$number_word[$lang]['d2-1'][$d1];
        } else if ($d2 != 0 && $d1 == 0) { // 10-20-...-90
            $group_array[] = static::$number_word[$lang]['d2-2'][$d2];
        } else if ($d2 == 0 && $d1 == 0) { // 00
        } else if ($d2 == 0 && $d1 != 0) { // 1-9
            $group_array[] = static::$number_word[$lang]['d1'][$d1];
        } else { // Others
            $group_array[] = static::$number_word[$lang]['d2-2'][$d2];
            $group_array[] = static::$number_word[$lang]['d1'][$d1];
        }
        if (!count($group_array)) {
            return FALSE;
        }
        return $group_array;
    }

    /**
     * return string of number
     *
     * @param string $number
     * @param string $lang
     * @return string
     */
    public static function getWords($number, $lang = 'fa') {
        $formated = self::number_format(strval($number), 0, '.', ',');
        $groups = explode(',', $formated);

        $steps = count($groups);

        $parts = array();
        foreach ($groups as $step => $group) {
            $group_words = self::groupToWords($group, $lang);
            if ($group_words) {
                $part = implode(' ' . static::$number_word[$lang]['and'] . ' ', $group_words);
            if (isset(static::$number_word[$lang]['step'][$steps - $step - 1])) {
                $part .= ' ' . static::$number_word[$lang]['step'][$steps - $step - 1];
            }
                $parts[] = $part;
            }
        }
        return implode(' ' . static::$number_word[$lang]['and'] . ' ', $parts);
    }

    /**
     * return persian string of number
     *
     * @param string $number
     * @return int
     */
    public static function getPersianWords ($number) {
        return self::getWords($number);
    }

    /**
     * return english string of number
     *
     * @param string $number
     * @return string
     */
    public static function getEnglishWords ($number) {
        return self::getWords($number, 'en');
    }

    /**
     * return rial string of number
     *
     * @param string $number
     * @return string
     */
    public static function getRial($number) {
        return self::getPersianWords($number) . ' ' . self::RIAL;
    }

    /**
     * return toman string of number
     *
     * @param string $number
     * @return string
     */
    public static function getToman($number) {
        return self::getPersianWords($number) . ' ' . self::TOMAN;
    }
}