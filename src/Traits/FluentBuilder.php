<?php

namespace Hekmatinasser\Verta\Traits;

use Carbon\Carbon;

/**
 * Trait FluentBuilder
 *
 * Provides a fluent interface for building a Jalali date/time step by step.
 */
trait FluentBuilder {
    /**
     * @var int|null The year component used in builder.
     */
    public ?int $Year = null;

    /**
     * @var int|null The month component used in builder.
     */
    public ?int $Month = null;

    /**
     * @var int|null The day component used in builder.
     */
    public ?int $Day = null;

    /**
     * @var int|null The hour component used in builder.
     */
    public ?int $Hour = null;

    /**
     * @var int|null The minute component used in builder.
     */
    public ?int $Minute = null;

    /**
     * @var int|null The second component used in builder.
     */
    public ?int $Second = null;

    /**
     * @var bool Flag to indicate if the builder values are Gregorian.
     */
    protected bool $isGregorian = false;

    /**
     * Set the day part.
     *
     * @param int $day
     * @return static
     */
    public function day( int $day ): static {
        $this->Day = $day;
        return $this;
    }

    /**
     * Set the hour part.
     *
     * @param int $hour
     * @return static
     */
    public function hour( int $hour ): static {
        $this->Hour = $hour;
        return $this;
    }

    /**
     * Set the minute part.
     *
     * @param int $minute
     * @return static
     */
    public function minute( int $minute ): static {
        $this->Minute = $minute;
        return $this;
    }

    /**
     * Set the month part.
     *
     * @param int $month
     * @return static
     */
    public function month( int $month ): static {
        $this->Month = $month;
        return $this;
    }

    /**
     * Set the second part.
     *
     * @param int $second
     * @return static
     */
    public function second( int $second ): static {
        $this->Second = $second;
        return $this;
    }

    /**
     * Set the year part.
     *
     * @param int $year
     * @return static
     */
    public function year( int $year ): static {
        $this->Year = $year;
        return $this;
    }

    /**
     * Mark the builder as Gregorian.
     *
     * @return $this
     */
    public function asGregorian(): static {
        $this->isGregorian = true;
        return $this;
    }

    /**
     * Build and return a new Verta instance.
     *
     * If isGregorian is true, treats Year/Month/Day as Gregorian and converts to Jalali.
     * Otherwise, treats them as Jalali.
     *
     * Defaults: year/month from current now, day=1, hour=0, minute=0, second=0.
     *
     * @return static
     */
    public function make(): static {
        $this->Year   = $this->Year ?? static::now()
            ->getYear();
        $this->Month  = $this->Month ?? static::now()
            ->getMonth();
        $this->Day    = $this->Day ?? 1;
        $this->Hour   = $this->Hour ?? 0;
        $this->Minute = $this->Minute ?? 0;
        $this->Second = $this->Second ?? 0;

        if ( $this->isGregorian ) {
            $carbon   = Carbon::create($this->Year, $this->Month, $this->Day, $this->Hour, $this->Minute, $this->Second);
            $instance = new static($carbon);
        }
        else {
            $instance = static::createJalali($this->Year, $this->Month, $this->Day, $this->Hour, $this->Minute, $this->Second);
        }

        $instance->Year   = $this->Year;
        $instance->Month  = $this->Month;
        $instance->Day    = $this->Day;
        $instance->Hour   = $this->Hour;
        $instance->Minute = $this->Minute;
        $instance->Second = $this->Second;

        return $instance;
    }

    /**
     * Create a new builder instance.
     *
     * @return static
     */
    public static function builder(): static {
        return new static();
    }
}