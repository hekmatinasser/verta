<?php

namespace Hekmatinasser\Verta\Traits;

use Hekmatinasser\Verta\Verta;

trait Comparison
{
    /**
     * check jalali the instance is a leap year
     *
     * @param int $year
     * @return bool
     */
    public static function isLeapYear($year)
    {
        return in_array(($year % 33), [1 , 5 , 9 , 13 ,17 , 22 , 26 , 30]);
    }

    /**
     * validate a jalali date (jalali equivalent of php checkdate() function)
     *
     * @param int $month
     * @param int $day
     * @param int $year
     * @return bool
     */
    public static function isValidDate($year, $month, $day)
    {
        if ($year < 0 || $year > 32766) {
            return false;
        }
        if ($month < 1 || $month > 12) {
            return false;
        }
        $dayLastMonthJalali = static::isLeapYear($year) && ($month == 12) ? 30 : static::$daysMonthJalali[intval($month) - 1];
        if ($day < 1 || $day > $dayLastMonthJalali) {
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
    public static function isValidTime($hour, $minute, $second)
    {
        return $hour >= 0 && $hour <= 23
            && $minute >= 0 && $minute <= 59
            && $second >= 0 && $second <= 59;
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
        return ! $this->eq($v);
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
        return ! $this->isWeekend();
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
    public function isNextWeek(): bool
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
        return $this->format('Y-m') === static::now($this->getTimezone())->addMonth()->format('Y-m');
    }

    /**
     * Determines if the instance is within the last month
     *
     * @return bool
     */
    public function isLastMonth()
    {
        return $this->format('Y-m') === static::now($this->getTimezone())->subMonth()->format('Y-m');
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
        $v = $v ?: static::now($this->getTimezone());

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
     *        $this->assertFalse($datetime->isCurrentMonth());

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
}
