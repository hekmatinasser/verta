<?php
if (! function_exists('verta')) {
    /**
     * @param string $str
     * @return \Hekmatinasse\Verta\Verta
     */
    function verta($string = null)
    {
        return \Hekmatinasse\Verta\Verta::instance($string);
    }
}