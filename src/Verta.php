<?php

namespace Hekmatinasser\Verta;

use Exception;
use Hekmatinasser\Jalali\Jalali;
use Illuminate\Support\Carbon;

class Verta extends Jalali
{
    /**
     * Create a Carbon instance from Verta
     *
     * @return Carbon
     * @throws Exception
     */
    public function toCarbon(): Carbon
    {
        return new Carbon($this->datetime(), $this->timezone);
    }
}
