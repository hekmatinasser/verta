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
    use Translator;
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
    protected static $weekendDays = [VertaInterface::THURSDAY, VertaInterface::FRIDAY];

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

}