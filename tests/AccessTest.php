<?php

namespace Hekmatinasser\Verta\Tests;

use Hekmatinasser\Verta\Verta;
use PHPUnit\Framework\TestCase;

class AccessTest extends TestCase
{
    public function testGetProperty()
    {
        $datetime = Verta('2019-01-01 17:20:35', 'Asia/Tehran');

        $this->assertEquals(1397, $datetime->year);
        $this->assertEquals(10, $datetime->month);
        $this->assertEquals(11, $datetime->day);
        $this->assertEquals(17, $datetime->hour);
        $this->assertEquals(20, $datetime->minute);
        $this->assertEquals(35, $datetime->second);
        $this->assertEquals(0, $datetime->micro);
        $this->assertEquals(3, $datetime->dayOfWeek);
        $this->assertEquals(286, $datetime->dayOfYear);
        $this->assertEquals(41, $datetime->weekOfYear);
        $this->assertEquals(30, $datetime->daysInMonth);
        $this->assertEquals(1546350635, $datetime->timestamp);
        $this->assertEquals(4, $datetime->quarter);
        $this->assertEquals('Asia/Tehran', $datetime->timezone);
    }

    public function testSetProperty()
    {
        $datetime = new Verta('2019-01-01 17:20:35', 'Asia/Tehran');

        $datetime->year = 1398;
        $this->assertEquals(1398, $datetime->year);

        $datetime->month = 12;
        $this->assertEquals(12, $datetime->month);

        $datetime->day = 15;
        $this->assertEquals(15, $datetime->day);

        $datetime->hour = 13;
        $this->assertEquals(13, $datetime->hour);

        $datetime->minute = 50;
        $this->assertEquals(50, $datetime->minute);

        $datetime->second = 45;
        $this->assertEquals(45, $datetime->second);

        $datetime->timestamp = 1546382684;
        $this->assertEquals(1546382684, $datetime->timestamp);

        $datetime->tz = 'UTC';
        $this->assertEquals('UTC', $datetime->timezone);
    }

    public function testSetMethods()
    {
        $datetime = verta();

        $datetime->year(1395);
        $this->assertEquals(1395, $datetime->year);

        $datetime->month(8);
        $this->assertEquals(8, $datetime->month);

        $datetime->day(19);
        $this->assertEquals(19, $datetime->day);

        $datetime->hour(22);
        $this->assertEquals(22, $datetime->hour);

        $datetime->minute(23);
        $this->assertEquals(23, $datetime->minute);

        $datetime->second(56);
        $this->assertEquals(56, $datetime->second);

        $datetime->timestamp(1546350635);
        $this->assertEquals(1546350635, $datetime->timestamp);

        $datetime->timezone('Asia/Tehran');
        $this->assertEquals('Asia/Tehran', $datetime->timezone);
    }


    public function testSetDateTime()
    {
        $datetime = verta()->setDateTime(1397,10,11,10,20,11);

        $this->assertEquals(1397, $datetime->year);
        $this->assertEquals(10, $datetime->month);
        $this->assertEquals(11, $datetime->day);
        $this->assertEquals(10, $datetime->hour);
        $this->assertEquals(20, $datetime->minute);
        $this->assertEquals(11, $datetime->second);
    }


    public function testSetDate()
    {
        $datetime = verta()->setDate(1397,10,11);

        $this->assertEquals(1397, $datetime->year);
        $this->assertEquals(10, $datetime->month);
        $this->assertEquals(11, $datetime->day);
    }

    public function testSetTime()
    {
        $datetime = verta()->setTime(10,20,11);

        $this->assertEquals(10, $datetime->hour);
        $this->assertEquals(20, $datetime->minute);
        $this->assertEquals(11, $datetime->second);
    }

    public function testSetTimeString()
    {
        $datetime = verta()->setTimeString('10:20:11');

        $this->assertEquals(10, $datetime->hour);
        $this->assertEquals(20, $datetime->minute);
        $this->assertEquals(11, $datetime->second);

    }
}
