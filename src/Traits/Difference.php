<?php


namespace Hekmatinasser\Verta\Traits;


use Hekmatinasser\Verta\Verta;

trait Difference
{

    /**
     * Get the difference in years
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffYears(Verta $v = null)
    {
        $v = $v ?: static::now($this->getTimezone());

        return (int) $this->diff($v->datetime())->format('%r%y');
    }

    /**
     * Get the difference in months
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffMonths(Verta $v = null)
    {
        $v = $v ?: static::now($this->getTimezone());

        return $this->diffYears($v) * static::MONTHS_PER_YEAR + (int) $this->diff($v->datetime())->format('%r%m');
    }

    /**
     * Get the difference in weeks
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffWeeks(Verta $v = null)
    {
        return (int) ($this->diffDays($v) / static::DAYS_PER_WEEK);
    }

    /**
     * Get the difference in days
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffDays(Verta $v = null)
    {
        $v = $v ?: static::now($this->getTimezone());

        return (int) $this->diff($v->datetime())->format('%r%a');
    }

    /**
     * Get the difference in hours
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffHours(Verta $v = null)
    {
        return (int) ($this->diffSeconds($v) / static::SECONDS_PER_MINUTE / static::MINUTES_PER_HOUR);
    }

    /**
     * Get the difference in minutes
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffMinutes(Verta $v = null)
    {
        return (int) ($this->diffSeconds($v) / static::SECONDS_PER_MINUTE);
    }

    /**
     * Get the difference in seconds
     *
     * @param Verta|null $v
     *
     * @return int
     */
    public function diffSeconds(Verta $v = null)
    {
        $v = $v ?: static::now($this->getTimezone());

        return $v->getTimestamp() - $this->getTimestamp();
    }

}