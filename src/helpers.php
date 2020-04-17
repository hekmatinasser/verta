<?php
if (! function_exists('verta')) {
    /**
     * @param string $str
     * @return \Hekmatinasse\Verta\Verta
     */
    function verta($string = null, $timezone = null)
    {
        return new \Hekmatinasser\Verta\Verta($string, $timezone);
    }
}