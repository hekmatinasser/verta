<?php

namespace Hekmatinasser\Verta\Traits;

trait Modification
{
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
        return $this->year($this->year + $value);
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
        return $this->addYears(-1 * $value);
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
        } elseif ($month < 1) {
            $year += intval($month / 12) - 1;
            $month = 12 + ($month % 12);
        }
        if ($month == 0) {
            $year--;
            $month = 12;
        }
        if (($month > 6 && $month < 12 && $day == 31)) {
            $day--;
        } else {
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
}
