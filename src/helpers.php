<?php
if (! function_exists('verta')) {
    /**
     * @param string $str
     * @return \Hekmatinasse\Verta\Verta
     */
    function verta($string = null, $timezone = null)
    {
        return \Hekmatinasser\Verta\Verta::instance($string, $timezone);
    }
}