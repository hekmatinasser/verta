<?php
if (! function_exists('notowo')) {
    /**
     * @param $number
     * @param string $lang
     * @return Hekmatinasser\Notowo\Notowo
     */
    function notowo($number, $lang = 'en')
    {
        return Hekmatinasser\Notowo\Notowo::parse($number, $lang);
    }
}