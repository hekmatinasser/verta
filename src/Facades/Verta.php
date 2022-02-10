<?php

namespace Hekmatinasser\Verta\Facades;

use Illuminate\Support\Facades\Facade;

class Verta extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'verta';
    }
}
