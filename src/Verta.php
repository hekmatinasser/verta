<?php

namespace Hekmatinasser\Verta;

use Hekmatinasser\Jalali\Jalali;
use Hekmatinasser\Verta\Traits\Converter;
use Hekmatinasser\Verta\Traits\FluentBuilder;
use Hekmatinasser\Verta\Traits\Getters;

class Verta extends Jalali {
    use Getters;
    use Converter;
    use FluentBuilder;
}