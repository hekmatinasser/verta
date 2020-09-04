<?php


namespace Hekmatinasser\Verta\Traits;


use Hekmatinasser\Verta\VertaInterface;

trait Date
{
    use Accessor;
    use Comparison;
    use Creator;
    use Formatting;
    use Modification;
    use Transformation;
    use Boundaries;
    use Difference;

    /**
     * Format to use for __toString.
     *
     * @var string
     */
    protected static $stringFormat = VertaInterface::DEFAULT_STRING_FORMAT;

    /**
     * First day of week.
     *
     * @var int
     */
    protected static $weekStartsAt = VertaInterface::SATURDAY;

    /**
     * Last day of week.
     *
     * @var int
     */
    protected static $weekEndsAt = VertaInterface::FRIDAY;

    /**
     * Days of weekend.
     *
     * @var array
     */
    protected static $weekendDays = [
        VertaInterface::THURSDAY,
        VertaInterface::FRIDAY,
    ];

    /**
     * number day in months gregorian
     *
     * @var array
     */
    protected static $daysMonthGregorian = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    /**
     * number day in month jalali
     *
     * @var array
     */
    protected static $daysMonthJalali = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];

    /**
     * month name jalali
     *
     * @var array
     */
    protected static $monthYear = [
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
    ];

    /**
     * Names of days of the week.
     *
     * @var array
     */
    protected static $dayWeek = [
        'شنبه',
        'یکشنبه',
        'دوشنبه',
        'سه شنبه',
        'چهارشنبه',
        'پنج شنبه',
        'جمعه',
    ];

    /**
     * unit date name.
     *
     * @var array
     */
    protected static $unitName = [
        'ثانیه',
        'دقیقه',
        'ساعت',
        'روز',
        'هفته',
        'ماه',
        'سال',
        'قرن'
    ];

    /**
     * unit date number.
     *
     * @var array
     */
    protected static $unitNumber = [
        VertaInterface::SECONDS_PER_MINUTE,
        VertaInterface::MINUTES_PER_HOUR,
        VertaInterface::HOURS_PER_DAY,
        VertaInterface::DAYS_PER_WEEK,
        VertaInterface::WEEKS_PER_MONTH,
        VertaInterface::MONTHS_PER_YEAR,
        VertaInterface::YEARS_PER_DECADE,
    ];

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
}