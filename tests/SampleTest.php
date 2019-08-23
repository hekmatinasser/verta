<?php

namespace Hekmatinasser\VertaTests;

use Hekmatinasser\Verta\Facades\Verta as VertaFacade;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function testVertaNow()
    {
        Carbon::setTestNow('2019-01-01 00:00:00');

        $shamsiDate = (string)Verta::now();
        $this->assertEquals('1397-10-11 00:00:00', $shamsiDate);
    }

    public function testVertaNow2()
    {
        Carbon::setTestNow('2019-01-01 00:00:01');

        $shamsiDate = (string)Verta::now();
        $this->assertEquals('1397-10-11 00:00:01', $shamsiDate);
    }

    public function testYesterday()
    {
        Carbon::setTestNow('2019-01-01 10:20:11');
        $shamsiDate = (string)Verta::yesterday();
        $this->assertEquals('1397-10-10 00:00:00', $shamsiDate);
        $shamsiDate = (string)Verta::tomorrow();
        $this->assertEquals('1397-10-12 00:00:00', $shamsiDate);
        $shamsiDate = (string)Verta::today();
        $this->assertEquals('1397-10-11 00:00:00', $shamsiDate);
    }

    public function testCreateFromString()
    {
        $v = new Verta('2019-01-01 10:20:11');
        $this->assertEquals('1397-10-11 10:20:11', (string)$v);

        $v = new Verta('2019-01-02 10:20:11');
        $this->assertEquals('1397-10-12 10:20:11', (string)$v);

        $v = Verta::instance('2019-01-01 10:20:11');
        $this->assertEquals('1397-10-11 10:20:11', (string)$v);

        $app = ['verta' => new Verta];
        VertaFacade::setFacadeApplication($app);

        $v = VertaFacade::instance('2019-01-01 10:20:11');

        $this->assertEquals('1397-10-11 10:20:11', (string)$v);
    }

    public function testDatetime()
    {
        $d = new \DateTime('2019-01-01 10:20:11');
        $f1 = new Verta($d);

        $f2 = new Verta('2019-01-01 10:20:11');

        $this->assertEquals((string)$f1, (string)$f2);
    }
}
