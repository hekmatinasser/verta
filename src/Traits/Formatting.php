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
    protected function date($format){
        $timestamp = $this->getTimestamp();


        list( $gYear, $gMonth, $gDay, $gWeek ) = explode( '-', parent::format('Y-m-d-w'));
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

        list($gYear, $gMonth, $gDay, $gWeek) = explode('-', parent::format('Y-m-d-w'));
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
                    $result .= (parent::format('a') == 'am' ? self::AM : self::PM);
                case 'A':
                    $result .= (parent::format('a') == 'am' ? self::ANTE_MERIDIEM : self::POST_MERIDIEM);
                    break;
                case 'B':
                case 'g':
                case 'G':
                case 'h':
                case 'H':
                case 's':
                case 'u':
                case 'i':
                    $result .= $word->getWord(strval(parent::format($par)));
                    break;
                case 'e':
                case 'I':
                case 'O':
                case 'P':
                case 'T':
                case 'Z':
                    $result .= parent::format($par);
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
        return str_replace(self::$arabicNumber, self::$englishNumber, $string);
    }

}