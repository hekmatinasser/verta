<?php

namespace Hekmatinasser\Verta\Traits;

/**
 * Trait Getters
 *
 * Provides accessor methods for the Jalali date components.
 */
trait Getters {
    /**
     * Get the Jalali year.
     *
     * @return int
     */
    public function getYear(): int {
        return $this->year;
    }

    /**
     * Get the Jalali month (1–12).
     *
     * @return int
     */
    public function getMonth(): int {
        return $this->month;
    }

    /**
     * Get the Jalali day of the month (1–31).
     *
     * @return int
     */
    public function getDay(): int {
        return $this->day;
    }

    /**
     * Get the number of days in the current Jalali month.
     *
     * @return int
     */
    public function getDaysInMonth(): int {
        return $this->daysInMonth();
    }

    /**
     * Get the hour (0–23).
     *
     * @return int
     */
    public function getHour(): int {
        return $this->hour;
    }

    /**
     * Get the minute (0–59).
     *
     * @return int
     */
    public function getMinute(): int {
        return $this->minute;
    }

    /**
     * Get the second (0–59).
     *
     * @return int
     */
    public function getSecond(): int {
        return $this->second;
    }

    /**
     * Get all date parts as an associative array.
     *
     * @return array{year:int, month:int, day:int, hour:int, minute:int, second:int}
     */
    public function getParts(): array {
        return [
            'year'   => $this->getYear(),
            'month'  => $this->getMonth(),
            'day'    => $this->getDay(),
            'hour'   => $this->getHour(),
            'minute' => $this->getMinute(),
            'second' => $this->getSecond(),
        ];
    }
}