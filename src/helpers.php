<?php

use Hekmatinasser\Jalali\Jalali;
use Hekmatinasser\Verta\Verta;

if (! function_exists('verta')) {
    /**
     * @param Jalali|DateTime|int|string|null $datetime
     * @param DateTimeZone|string|null $timezone
     * @return Verta
     */
    function verta(Jalali|DateTime|int|string|null $datetime = null, DateTimeZone|string|null $timezone = null): Verta
    {
        return new Verta($datetime, $timezone);
    }
}
