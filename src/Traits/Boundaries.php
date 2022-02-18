<?php

namespace Hekmatinasser\Verta\Traits;

trait Boundaries
{
    /**
     * Resets the time to 00:00:00
     *
     * @return static
     */
    public function startMinute()
    {
        return $this->setTime($this->hour, $this->minute, 0);
    }

    /**
     * Resets the time to 23:59:59
     *
     * @return static
     */
    public function endMinute()
    {
        return $this->setTime($this->hour, $this->minute, 59);
    }

    /**
     * Resets the time to 00:00:00
     *
     * @return static
     */
    public function startHour()
    {
        return $this->setTime($this->hour, 0, 0);
    }

    /**
     * Resets the time to 23:59:59
     *
     * @return static
     */
    public function endHour()
    {
        return $this->setTime($this->hour, 59, 59);
    }

    /**
     * Resets the time to 00:00:00
     *
     * @return static
     */
    public function startDay()
    {
        return $this->setTime(0, 0, 0);
    }

    /**
     * Resets the time to 23:59:59
     *
     * @return static
     */
    public function endDay()
    {
        return $this->setTime(23, 59, 59);
    }

    /**
     * Resets the date to the first day of week (defined in $weekStartsAt) and the time to 00:00:00
     *
     * @return static
     */
    public function startWeek()
    {
        while ($this->dayOfWeek !== static::$weekStartsAt) {
            $this->subDay();
        }

        return $this->startDay();
    }

    /**
     * Resets the date to end of week (defined in $weekEndsAt) and time to 23:59:59
     *
     * @return static
     */
    public function endWeek()
    {
        while ($this->dayOfWeek !== static::$weekEndsAt) {
            $this->addDay();
        }

        return $this->endDay();
    }

    /**
     * Resets the date to the first day of the month and the time to 00:00:00
     *
     * @return static
     */
    public function startMonth()
    {
        return $this->setDateTime($this->year, $this->month, 1, 0, 0, 0);
    }

    /**
     * Resets the date to end of the month and time to 23:59:59
     *
     * @return static
     */
    public function endMonth()
    {
        return $this->setDateTime($this->year, $this->month, $this->daysInMonth, 23, 59, 59);
    }

    /**
     * Resets the date to the first day of the quarter and the time to 00:00:00
     *
     * @return static
     */
    public function startQuarter()
    {
        $month = ($this->quarter - 1) * static::MONTHS_PER_QUARTER + 1;

        return $this->setDateTime($this->year, $month, 1, 0, 0, 0);
    }

    /**
     * Resets the date to end of the quarter and time to 23:59:59
     *
     * @return static
     */
    public function endQuarter()
    {
        $month = $this->quarter * static::MONTHS_PER_QUARTER;

        return $this->setDateJalali($this->year, $month, 1)->endMonth();
    }

    /**
     * Resets the date to the first day of the year and the time to 00:00:00
     *
     * @return static
     */
    public function startYear()
    {
        return $this->setDateTime($this->year, 1, 1, 0, 0, 0);
    }

    /**
     * Resets the date to end of the year and time to 23:59:59
     *
     * @return static
     */
    public function endYear()
    {
        $day = $this->format('L') ? 30 : 29;

        return $this->setDateTime($this->year, 12, $day, 23, 59, 59);
    }
}
