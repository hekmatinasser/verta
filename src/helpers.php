<?php

use Hekmatinasser\Jalali\Jalali;
use Hekmatinasser\Verta\Verta;

if (! function_exists('verta')) {
    /**
     * @param  Jalali|DateTime|string|int|null  $datetime
     * @param  DateTimeZone|string|null  $timezone
     * @return Verta
     */
    function verta($datetime = null, $timezone = null): Verta
    {
        return new Verta($datetime, $timezone);
    }
}
