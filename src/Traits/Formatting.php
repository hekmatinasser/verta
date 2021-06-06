<?php


namespace Hekmatinasser\Verta\Traits;


use Hekmatinasser\Notowo\Notowo;
use Hekmatinasser\Verta\Verta;

trait Formatting
{

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
    protected function date($format)
    {
        $timestamp = $this->getTimestamp();

        list( $gYear, $gMonth, $gDay, $gWeek ) = explode( '-', parent::format('Y-m-d-w'));
        list( $pYear, $pMonth, $pDay ) = static::getJalali( $gYear, $gMonth, $gDay );

        $pWeek = $gWeek + 1;

        if ($pWeek >= 7) {
            $pWeek = 0;
        }

        $lengh = strlen($format);
        $index = 0;
        $result = '';

        while ($index < $lengh) {
            $char =  $format[$index];
            if ($char == '\\') {
                $result .= $format[++$index];
                $index++;
                continue;
            }
            $result .= $this->characterFormat($char, $timestamp, $pYear, $pMonth, $pDay, $pWeek);

            $index++;
        }
        return $result;
    }


    /**
     * The format of the outputted date charactre (jalali equivalent of php date() function)
     *
     * @param string $char
     * @param integer $timestamp
     * @param integer $pYear
     * @param integer $pMonth
     * @param integer $pDay
     * @param integer $pWeek
     * @return string
     */
    private function characterFormat($char, $timestamp, $pYear, $pMonth, $pDay, $pWeek)
    {
        switch ($char) {
            # Day
            case 'd':
                return sprintf( '%02s', $pDay );

            case 'D':
                return substr( self::$messages['weekdays'][$pWeek+1], 0, 2 );

            case 'j':
                return $pDay;

            case 'l':
                return self::$messages['weekdays'][$pWeek+1];

            case 'N':
                return $pWeek+1;

            case 'w':
                return $pWeek;

            case 'z':
                return $this->daysYear( $pMonth, $pDay );

            case 'S':
                return static::$messages['phrase']['th'];

            # Week
            case 'W':
                return ceil( $this->daysYear( $pMonth, $pDay ) / 7 );

            # Month
            case 'F':
                return self::$messages['year_months'][$pMonth];

            case 'm':
                return sprintf( '%02s', $pMonth );

            case 'M':
                return substr(self::$messages['year_months'][$pMonth], 0, 6 );

            case 'n':
                return $pMonth;

            case 't':
                return static::isLeapYear( $pYear ) && ( $pMonth == 12 ) ? 30 : static::$daysMonthJalali[ intval( $pMonth ) - 1 ];

            # Years
            case 'L':
                return intval( $this->isLeapYear( $pYear ) );

            case 'Y':
            case 'o':
                return $pYear;

            case 'y':
                return substr( $pYear, 2 );

            # Time
            case 'a':
                return static::$messages['phrase'][parent::format('a')];

            case 'A':
                return static::$messages['pharse'][parent::format('a') == 'am' ? 'ante_meridiem' : 'post_meridiem'];

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
                return parent::format( $char );

            # Full Date/Time
            case 'c':
                return ( $pYear . '-' . $pMonth . '-' . $pDay . ' ' . parent::format( 'H:i:s P' ) );

            case 'r':
                return ( substr(self::$messages['weekdays'][$pWeek], 0, 2 ) . '، ' . $pDay . ' ' . substr(self::$messages['year_months'][$pMonth], 0, 6 ) . ' ' . $pYear . ' ' . parent::format( 'H:i:s P' ) );

            case 'U':
                return $timestamp;

            default:
                return $char;
        }
    }

    /**
     * The format of the outputted date string (jalali equivalent of php date() function)
     *
     * @param string $format for example 'Y-m-d H:i:s'
     * @return string
     */
    protected function dateWord($format){

        $timestamp = $this->getTimestamp();

        list( $gYear, $gMonth, $gDay, $gWeek ) = explode( '-', parent::format('Y-m-d-w'));
        list( $pYear, $pMonth, $pDay ) = static::getJalali( $gYear, $gMonth, $gDay );

        $pWeek = $gWeek + 1;

        if ($pWeek >= 7) {
            $pWeek = 0;
        }

        $lengh = strlen($format);
        $index = 0;
        $result = '';

        while ($index < $lengh) {
            $char =  $format[$index];
            if ($char == '\\') {
                $result .= $format[++$index];
                $index++;
                continue;
            }
            $output = $this->characterFormat($char, $timestamp, $pYear, $pMonth, $pDay, $pWeek);
            if(is_numeric($output)) {
                $output = (string) new Notowo($output, static::getLocale() == 'en' ? 'en' : 'fa' );
            }
            $result .= $output;

            $index++;
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
        $strftime_date = array(
            "%a" => "D",
            "%A" => "l",
            "%d" => "d",
            "%e" => "j",
            "%j" => "z",
            "%u" => "N",
            "%w" => "w",
            "%U" => "W",
            "%V" => "W",
            "%W" => "W",
            "%b" => "M",
            "%B" => "F",
            "%h" => "M",
            "%m" => "m",
            "%C" => "y",
            "%g" => "y",
            "%G" => "y",
            "%y" => "y",
            "%Y" => "Y",
            "%H" => "H",
            "%I" => "h",
            "%l" => "g",
            "%M" => "i",
            "%p" => "A",
            "%P" => "a",
            "%r" => "h:i:s A",
            "%R" => "H:i",
            "%S" => "s",
            "%T" => "H:i:s",
            "%X" => "h:i:s",
            "%z" => "H",
            "%Z" => "H",
            "%c" => "D j M H:i:s",
            "%D" => "d/m/y",
            "%F" => "Y-m-d",
            "%s" => "U",
            "%x" => "d/m/y",
            "%n" => "\n",
            "%t" => "\t",
            "%%" => "%",
        );

        return str_replace(array_keys($strftime_date), array_values($strftime_date), $format);
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
        $units = [
            static::SECONDS_PER_MINUTE,
            static::MINUTES_PER_HOUR,
            static::HOURS_PER_DAY,
            static::DAYS_PER_WEEK,
            static::WEEKS_PER_MONTH,
            static::MONTHS_PER_YEAR,
            static::YEARS_PER_DECADE,
            static::DECADE_PER_CENTURY,
        ];
        $difference = $this->diffSeconds($v);
        $absolute = static::$messages['phrase'][$difference < 0 ? 'later' : 'ago'];

        $difference = abs($difference);

        for ($unit = 0; $difference >= $units[$unit] and $unit < count($units) - 1; $unit++) {
            $difference /= $units[$unit];
        }
        $difference = intval(round($difference));

        if($difference === 0) {
            return static::$messages['phrase']['now'];
        }

        return sprintf('%s %s %s', $difference, array_values(static::$messages['date_units'])[$unit], $absolute);
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
        $en = static::getMessages('en');
        $fa = static::getMessages('fa');
        return str_replace(array_values($en['numbers']), array_values($fa['numbers']), $string);
    }

    /**
     * Convert english numbers to persian numbers
     *
     * @param string $string
     * @return string
     */
    public static function faToEnNumbers($string)
    {
        $fa = static::getMessages('fa');
        $en = static::getMessages('en');
        return str_replace(array_values($fa['numbers']), array_values($en['numbers']), $string);
    }

    /**
     * Convert english numbers to persian numbers
     *
     * @param string $string
     * @return string
     */
    public static function arToEnNumbers($string)
    {
        $ar = static::getMessages('ar');
        $en = static::getMessages('en');
        return str_replace(array_values($ar['numbers']), array_values($en['numbers']), $string);
    }

}