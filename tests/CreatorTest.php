<?php

namespace Hekmatinasser\Verta\Tests;

use DateTime;
use Hekmatinasser\Verta\Facades\Verta as VertaFacade;
use Hekmatinasser\Verta\Verta;
use PHPUnit\Framework\TestCase;

class CreatorTest extends TestCase
{
    public function testNow()
    {
        $expected = (new DateTime())->getTimestamp();
        $actual = Verta::now()->getTimestamp();

        $this->assertEquals($expected, $actual);
    }

    public function testHelper()
    {
        $expected = (new DateTime())->getTimestamp();
        $actual = verta()->getTimestamp();

        $this->assertEquals($expected, $actual);

    }

    public function testYesterday()
    {
        $expected = (new DateTime("-1 days"))->format('Y-m-d 00:00:00');
        $actual = (string)Verta::yesterday()->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals($expected, $actual);
    }

    public function testToday()
    {
        $expected = (new DateTime())->format('Y-m-d 00:00:00');
        $actual = (string)Verta::today()->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals($expected, $actual);
    }

    public function testTomorrow()
    {
        $expected = (new DateTime("+1 days"))->format('Y-m-d 00:00:00');
        $actual = (string)Verta::tomorrow()->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals($expected, $actual);
    }

    public function testInstance()
    {
        $datetime = (string) new Verta('2019-01-01 10:20:11');

        $this->assertEquals('1397-10-11 10:20:11', $datetime);


        $datetime = (string) Verta::instance('2019-01-01 10:20:11');
        $this->assertEquals('1397-10-11 10:20:11', $datetime);

        $app = ['verta' => new Verta];
        VertaFacade::setFacadeApplication($app);

        $datetime = (string) VertaFacade::instance('2019-01-01 10:20:11');

        $this->assertEquals('1397-10-11 10:20:11', $datetime);
    }

    public function testDatetime()
    {
        $datetime = verta('2019-01-01 10:20:11')->DateTime()->format('Y-m-d H:i:s');

        $this->assertEquals('2019-01-01 10:20:11', $datetime);
    }

    public function testParse()
    {
        $datetime = Verta::parse('1397-10-11 10:20:11')->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals('2019-01-01 10:20:11', $datetime);
    }

    public function testParseFormat()
    {
        $datetime = Verta::parseFormat('Y-m-d H:i:s','1397-10-11 10:20:11')->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals('2019-01-01 10:20:11', $datetime);
    }

    public function testCreate()
    {
        $datetime = Verta::create(2019,1,1,10,20,11)->format('Y-m-d H:i:s');

        $this->assertEquals('1397-10-11 10:20:11', $datetime);
    }

    public function testCreateDate()
    {
        $time = (new DateTime())->format("H:i:s");
        $datetime = Verta::createDate(2019,1,1)->format('Y-m-d H:i:s');

        $this->assertEquals("1397-10-11 {$time}", $datetime);
    }

    public function testCreateTime()
    {
        $date = (new DateTime())->format("Y-m-d");
        $datetime = Verta::createTime(15,19,51)->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals("{$date} 15:19:51", $datetime);
    }

    public function testCreateTimestamp()
    {
        $datetime = Verta::createTimestamp(1583501791)->format('Y-m-d H:i:s');

        $this->assertEquals("1398-12-16 13:36:31", $datetime);
    }

    public function testCreateGregorian()
    {
        $datetime = Verta::create(2019,1,1,10,20,11)->format('Y-m-d H:i:s');

        $this->assertEquals('1397-10-11 10:20:11', $datetime);
    }

    public function testCreateGregorianDate()
    {
        $time = (new DateTime())->format("H:i:s");
        $datetime = Verta::createGregorianDate(2019,1,1)->format('Y-m-d H:i:s');

        $this->assertEquals("1397-10-11 {$time}", $datetime);
    }

    public function testCreateGregorianTime()
    {
        $date = (new DateTime())->format("Y-m-d");
        $datetime = Verta::createGregorianTime(15,19,51)->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals("{$date} 15:19:51", $datetime);
    }

    public function testCreateJalali()
    {
        $datetime = Verta::createJalali(1397,10,11,10,20,11)->format('Y-m-d H:i:s');

        $this->assertEquals('1397-10-11 10:20:11', $datetime);
    }

    public function testCreateJalaliDate()
    {
        $time = (new DateTime())->format("H:i:s");
        $datetime = Verta::createJalaliDate(1397,10,11)->format('Y-m-d H:i:s');

        $this->assertEquals("1397-10-11 {$time}", $datetime);
    }

    public function testCreateJalaliTime()
    {
        $date = verta()->format("Y-m-d");
        $datetime = Verta::createJalaliTime(15,19,51)->format('Y-m-d H:i:s');

        $this->assertEquals("{$date} 15:19:51", $datetime);
    }
}
