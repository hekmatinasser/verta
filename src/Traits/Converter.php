<?php

namespace Hekmatinasser\Verta\Traits;

use Carbon\Carbon;
use DateTimeInterface;
use Hekmatinasser\Verta\Verta;

/**
 * Trait Converter
 *
 * Provides conversion methods between Verta (Jalali) and Carbon (Gregorian)
 * as well as intelligent factory methods.
 */
trait Converter {
    /**
     * Convert the current Verta instance to a Carbon instance.
     *
     * @return Carbon
     */
    public function toCarbon(): Carbon {
        return new Carbon($this->datetime(), $this->timezone);
    }

    /**
     * Return the current instance (no conversion needed for Jalali).
     *
     * @return static
     */
    public function toJalali(): static {
        return $this;
    }

    /**
     * Create a Verta instance from a Carbon instance.
     *
     * If null is given, a new builder instance is returned.
     * The builder properties are populated from the created date.
     *
     * @param Carbon|null $carbon
     * @return static
     */
    public static function fromCarbon( ?Carbon $carbon = null ): static {
        if ( $carbon === null ) {
            $builder              = static::builder();
            $builder->isGregorian = true;
            return $builder;
        }

        $verta         = new static($carbon);
        $verta->Year   = $verta->getYear();
        $verta->Month  = $verta->getMonth();
        $verta->Day    = $verta->getDay();
        $verta->Hour   = $verta->getHour();
        $verta->Minute = $verta->getMinute();
        $verta->Second = $verta->getSecond();

        $verta->isGregorian = true;

        return $verta;
    }

    /**
     * Create a clone of a Verta instance.
     *
     * If null is given, a new builder instance is returned.
     * The builder properties are populated from the cloned date.
     *
     * @param Verta|null $verta
     * @return static
     */
    public static function fromJalali( ?Verta $verta = null ): static {
        if ( $verta === null ) {
            return static::builder();
        }

        $cloned         = clone $verta;
        $cloned->Year   = $cloned->getYear();
        $cloned->Month  = $cloned->getMonth();
        $cloned->Day    = $cloned->getDay();
        $cloned->Hour   = $cloned->getHour();
        $cloned->Minute = $cloned->getMinute();
        $cloned->Second = $cloned->getSecond();

        $cloned->isGregorian = false;

        return $cloned;
    }

    /**
     * Intelligent conversion factory.
     *
     * - Verta → Carbon
     * - Carbon → Verta (with builder populated)
     * - DateTimeInterface → Verta (with builder populated)
     * - Other → interpreted as Jalali date string (with builder populated)
     *
     * @param mixed $datetime
     * @param mixed $timezone
     * @return Carbon|static
     */
    public static function from( $datetime, $timezone = null ) {
        if ( $datetime instanceof Verta ) {
            return $datetime->toCarbon();
        }

        $verta = null;
        if ( $datetime instanceof Carbon ) {
            $verta = new static($datetime, $timezone);
        }
        elseif ( $datetime instanceof DateTimeInterface ) {
            $verta = new static($datetime, $timezone);
        }
        else {
            $verta = new static($datetime, $timezone);
        }

        $verta->Year   = $verta->getYear();
        $verta->Month  = $verta->getMonth();
        $verta->Day    = $verta->getDay();
        $verta->Hour   = $verta->getHour();
        $verta->Minute = $verta->getMinute();
        $verta->Second = $verta->getSecond();

        $verta->isGregorian = ( $datetime instanceof Carbon || $datetime instanceof DateTimeInterface );

        return $verta;
    }
}