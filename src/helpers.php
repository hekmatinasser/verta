<?php
if (! function_exists('verta')) {
    /**
     * @param null $datetime
     * @param null $timezone
     * @return \Hekmatinasse\Verta\Verta
     */
    function verta($datetime = null, $timezone = null)
    {
        return new \Hekmatinasser\Verta\Verta($datetime, $timezone);
    }
}