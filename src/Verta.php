<?php

namespace Hekmatinasser\Verta;

use Exception;
use Hekmatinasser\Jalali\Jalali;
use Illuminate\Support\Carbon;
use Illuminate\Support\Traits\Macroable;

class Verta extends Jalali
{
    use Macroable;

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
