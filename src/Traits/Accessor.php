<?php

namespace Hekmatinasser\Verta\Traits;

use DateTimeZone;
use Hekmatinasser\Verta\Verta;
use InvalidArgumentException;

trait Accessor
{
    /**
     * Get a part of the Verta object
     *
     * @param string $name
     * @return string|int
     *@throws InvalidArgumentException
     */
    public function __get($name)
    {
        static $formats = [
            'year' => 'Y',
            'month' => 'n',
            'day' => 'j',
            'hour' => 'G',
            'minute' => 'i',
            'second' => 's',
            'micro' => 'u',
            'dayOfWeek' => 'w',
            'dayOfYear' => 'z',
            'weekOfYear' => 'W',
            'daysInMonth' => 't',
            'timestamp' => 'U',
        ];

        if (array_key_exists($name, $formats)) {
            return (int) $this->format($formats[$name]);
        } elseif ($name === 'quarter') {
            return (int) ceil($this->month / static::MONTHS_PER_QUARTER);
        } elseif ($name === 'timezone') {
            return $this->getTimezone()->getName();
        }

        throw new InvalidArgumentException(sprintf("Unknown getter '%s'", $name));
    }

    /**
     * Check if an attribute exists on the object
     *
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        try {
            $this->__get($name);
        } catch (InvalidArgumentException $e) {
            return false;
        }

        return true;
    }

    /**
     * Set a part of the Verta object
     *
     * @param string $name
     * @param \DateTimeZone|int|string $value
     * @throws \InvalidArgumentException
     */
    public function __set($name, $value)
    {
        switch ($name) {
            case 'year':
            case 'month':
            case 'day':
            case 'hour':
            case 'minute':
            case 'second':
                list($year, $month, $day, $hour, $minute, $second) = explode('-', $this->format('Y-n-j-G-i-s'));
                $$name = $value;
                $this->setDateTime($year, $month, $day, $hour, $minute, $second);

                break;

            case 'timestamp':
                $this->setTimestamp($value);

                break;

            case 'timezone':
            case 'tz':
                $this->setTimezone(new DateTimeZone($value));

                break;

            default:
                throw new InvalidArgumentException(sprintf("Unknown setter '%s'", $name));
        }
    }

    /**
     * Set the instance's year
     *
     * @param int $value
     * @return static
     */
    public function year($value)
    {
        $this->year = $value;

        return $this;
    }

    /**
     * Set the instance's month
     *
     * @param int $value
     * @return static
     */
    public function month($value)
    {
        $this->month = $value;

        return $this;
    }

    /**
     * Set the instance's day
     *
     * @param int $value
     * @return static
     */
    public function day($value)
    {
        $this->day = $value;

        return $this;
    }

    /**
     * Set the instance's hour
     *
     * @param int $value
     * @return static
     */
    public function hour($value)
    {
        $this->hour = $value;

        return $this;
    }

    /**
     * Set the instance's minute
     *
     * @param int $value
     * @return static
     */
    public function minute($value)
    {
        $this->minute = $value;

        return $this;
    }

    /**
     * Set the instance's second
     *
     * @param int $value
     * @return static
     */
    public function second($value)
    {
        $this->second = $value;

        return $this;
    }

    /**
     * Set the instance's timestamp
     *
     * @param int $value
     * @return static
     */
    public function timestamp($value)
    {
        return parent::setTimestamp($value);
    }

    /**
     * Alias for setTimezone()
     *
     * @param \DateTimeZone|string $value
     *
     * @return static
     */
    public function timezone($value)
    {
        return parent::setTimezone(new DateTimeZone($value));
    }

    /**
     * Set the date and time all together
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param int $microseconds
     *
     * @return Verta
     */
    public function setDateTime($year, $month, $day, $hour, $minute, $second = 0, $microseconds = 0)
    {
        return $this->setDateJalali($year, $month, $day)->setTime($hour, $minute, $second, $microseconds);
    }

    /**
     * Sets the current date of the DateTime object to a different date.
     * Calls modify as a workaround for a php bug
     *
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return Verta
     */
    public function setDateJalali($year, $month, $day): Verta
    {
        if (static::isValidDate($year, $month, $day)) {
            list($year, $month, $day) = self::getGregorian($year, $month, $day);
            parent::setDate($year, $month, $day);
        }

        return $this;
    }

    /**
     * Set the time by time string
     *
     * @param string $time
     * @return Verta
     * @throws \InvalidArgumentException
     */
    public function setTimeString($time): Verta
    {
        $time = explode(':', $time);

        $hour = $time[0];
        $minute = $time[1] ?? 0;
        $second = $time[2] ?? 0;

        if (static::isValidTime($hour, $minute, $second)) {
            parent::setTime($hour, $minute, $second, 0);
        }

        return $this;
    }
}
