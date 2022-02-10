<?php

namespace Hekmatinasser\Verta;

interface VertaInterface
{
    /**
     * The day constants
     */
    public const SATURDAY = 0;
    public const SUNDAY = 1;
    public const MONDAY = 2;
    public const TUESDAY = 3;
    public const WEDNESDAY = 4;
    public const THURSDAY = 5;
    public const FRIDAY = 6;

    /**
     * Number unit in date
     */
    public const DECADE_PER_CENTURY = 10;
    public const YEARS_PER_DECADE = 10;
    public const MONTHS_PER_YEAR = 12;
    public const MONTHS_PER_QUARTER = 3;
    public const WEEKS_PER_YEAR = 52;
    public const WEEKS_PER_MONTH = 4.35;
    public const DAYS_PER_WEEK = 7;
    public const HOURS_PER_DAY = 24;
    public const MINUTES_PER_HOUR = 60;
    public const SECONDS_PER_MINUTE = 60;

    /**
     * Word use in format datetime.
     */
    public const DEFAULT_STRING_FORMAT = 'Y-m-d H:i:s';

    /**
     * Word use in format datetime.
     */
    public const DEFAULT_LOCALE = 'fa';
}
