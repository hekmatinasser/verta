<?php

namespace Hekmatinasser\Jalali\Tests;

use DateTime;
use DateTimeZone;
use Hekmatinasser\Jalali\Jalali;
use PHPUnit\Framework\TestCase;

class CreatorTest extends TestCase
{
    public function testNow()
    {
        $expected = (new DateTime())->getTimestamp();
        $actual = Jalali::now()->getTimestamp();

        $this->assertEquals($expected, $actual);
    }

    public function testHelper()
    {
        $expected = (new DateTime())->getTimestamp();
        $actual = Jalali()->getTimestamp();

        $this->assertEquals($expected, $actual);
    }

    public function testYesterday()
    {
        $expected = (new DateTime("-1 days"))->format('Y-m-d 00:00:00');
        $actual = (string)Jalali::yesterday()->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals($expected, $actual);
    }

    public function testToday()
    {
        $expected = (new DateTime())->format('Y-m-d 00:00:00');
        $actual = (string)Jalali::today()->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals($expected, $actual);
    }

    public function testTomorrow()
    {
        $expected = (new DateTime("+1 days"))->format('Y-m-d 00:00:00');
        $actual = (string)Jalali::tomorrow()->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals($expected, $actual);
    }

    public function testInstance()
    {
        $datetime = (string) new Jalali('2019-01-01 10:20:11');

        $this->assertEquals('1397-10-11 10:20:11', $datetime);

        $datetime = (string) Jalali::instance('2019-01-01 10:20:11');
        $this->assertEquals('1397-10-11 10:20:11', $datetime);
    }

    public function testInstanceFromDateTimeWithTimezone()
    {
        $now = new DateTime('now', new DateTimeZone('Asia/Tehran'));

        $datetime = new Jalali($now, 'Asia/Tehran');

        $this->assertEquals($now->getTimezone()->getName(), $datetime->getTimezone()->getName());
    }

    public function testDatetime()
    {
        $datetime = jalali('2019-01-01 10:20:11')->datetime()->format('Y-m-d H:i:s');

        $this->assertEquals('2019-01-01 10:20:11', $datetime);
    }

    public function testParse()
    {
        $datetime = Jalali::parse('1397 دی 11 10:20:11')->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals('2019-01-01 10:20:11', $datetime);
    }

    public function testParseFormat()
    {
        $datetime = Jalali::parseFormat('Y-m-d H:i:s', '1397-10-11 10:20:11')->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals('2019-01-01 10:20:11', $datetime);
    }

    public function testCreate()
    {
        $datetime = Jalali::create(2019, 1, 1, 10, 20, 11)->format('Y-m-d H:i:s');

        $this->assertEquals('1397-10-11 10:20:11', $datetime);
    }

    public function testCreateDate()
    {
        $time = (new DateTime())->format("H:i:s");
        $datetime = Jalali::createDate(2019, 1, 1)->format('Y-m-d H:i:s');

        $this->assertEquals("1397-10-11 {$time}", $datetime);
    }

    public function testCreateTime()
    {
        $date = (new DateTime())->format("Y-m-d");
        $datetime = Jalali::createTime(15, 19, 51)->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals("{$date} 15:19:51", $datetime);
    }

    public function testCreateTimestamp()
    {
        $datetime = Jalali::createTimestamp(1583501791)->format('Y-m-d H:i:s');

        $this->assertEquals("1398-12-16 13:36:31", $datetime);
    }

    public function testCreateGregorian()
    {
        $datetime = Jalali::create(2019, 1, 1, 10, 20, 11)->format('Y-m-d H:i:s');

        $this->assertEquals('1397-10-11 10:20:11', $datetime);
    }

    public function testCreateGregorianDate()
    {
        $time = (new DateTime())->format("H:i:s");
        $datetime = Jalali::createGregorianDate(2019, 1, 1)->format('Y-m-d H:i:s');

        $this->assertEquals("1397-10-11 {$time}", $datetime);
    }

    public function testCreateGregorianTime()
    {
        $date = (new DateTime())->format("Y-m-d");
        $datetime = Jalali::createGregorianTime(15, 19, 51)->formatGregorian('Y-m-d H:i:s');

        $this->assertEquals("{$date} 15:19:51", $datetime);
    }

    public function testCreateJalali()
    {
        $datetime = Jalali::createJalali(1397, 10, 11, 10, 20, 11)->format('Y-m-d H:i:s');

        $this->assertEquals('1397-10-11 10:20:11', $datetime);
    }

    public function testCreateJalaliDate()
    {
        $time = (new DateTime())->format("H:i:s");
        $datetime = Jalali::createJalaliDate(1397, 10, 11)->format('Y-m-d H:i:s');

        $this->assertEquals("1397-10-11 {$time}", $datetime);
    }

    public function testCreateJalaliTime()
    {
        $date = jalali()->format("Y-m-d");
        $datetime = Jalali::createJalaliTime(15, 19, 51)->format('Y-m-d H:i:s');

        $this->assertEquals("{$date} 15:19:51", $datetime);
    }
}
