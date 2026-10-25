<?php

use Hekmatinasser\Jalali\Jalali;
use Hekmatinasser\Verta\Verta;

if (! function_exists('verta')) {
    /**
     * @param DateTime|int|string|Jalali|null $datetime
     * @param DateTimeZone|string|null $timezone
     * @return Verta
     */
    function verta(DateTime|int|string|Jalali $datetime = null, DateTimeZone|string $timezone = null): Verta
    {
        return new Verta($datetime, $timezone);
    }
}
