<?php

use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function testHello()
    {

        $this->assertEquals(time(), Carbon::now()->getTimeStamp());
        Carbon::setTestNow('2019-1-1 00:00:00');
    }

    public function testVertaNow()
    {
        Carbon::setTestNow('2019-1-1 00:00:00');
        $shamsiData = (string)Verta::now();
        $this->assertEquals('1397-10-11 00:00:00', $shamsiData);
    }
}