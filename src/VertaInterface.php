<?php


namespace Hekmatinasser\Verta;


interface VertaInterface
{
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
}