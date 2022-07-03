<?php

namespace Hekmatinasser\Jalali\Tests;

use Hekmatinasser\Jalali\Jalali;
use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase
{
    public function testSetFormat()
    {
        Jalali::setFormat('Y-m-d-H-i-s');
        $datetime = (string) Jalali::parse('1398-10-10 22:30:50');

        $this->assertEquals('1398-10-10-22-30-50', $datetime);


        Jalali::resetFormat();
        $datetime = (string) Jalali::parse('1398-10-10 22:30:50');

        $this->assertEquals('1398-10-10 22:30:50', $datetime);
    }

    public function testFormat()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50')->format('y-n-j-g-i-s');

        $this->assertEquals('98-10-10-9-30-50', $datetime);
    }

    public function testFormatGregorian()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50')->formatGregorian('o n j g i s');

        $this->assertEquals('2020 12 31 9 30 50', $datetime);
    }

    public function testFormatDatetime()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50')->formatDatetime();

        $this->assertEquals('1398-10-10 21:30:50', $datetime);
    }

    public function testFormatDate()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50')->formatDate();

        $this->assertEquals('1398-10-10', $datetime);
    }

    public function testFormatTime()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50')->formatTime();

        $this->assertEquals('21:30:50', $datetime);
    }

    public function testFormatJalaliDatetime()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50')->formatJalaliDatetime();

        $this->assertEquals('1398/10/10 21:30:50', $datetime);
    }

    public function testFormatJalaliDate()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50')->formatJalaliDate();

        $this->assertEquals('1398/10/10', $datetime);
    }

    public function testFormatDifference()
    {
        Jalali::setLocale('fa');
        $target = Jalali::parse('1398-10-10 21:30:50');

        $datetime = Jalali::parse('1398-10-10 21:30:50');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('الان', $difference);

        $datetime = Jalali::parse('1398-10-10 21:30:45');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('5 ثانیه بعد', $difference);

        $datetime = Jalali::parse('1398-10-10 21:31:58');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('1 دقیقه قبل', $difference);

        $datetime = Jalali::parse('1398-10-10 20:30:35');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('1 ساعت بعد', $difference);

        $datetime = Jalali::parse('1398-10-11 21:32:35');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('1 روز قبل', $difference);

        $datetime = Jalali::parse('1398-11-11 21:32:35');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('1 ماه قبل', $difference);

        $datetime = Jalali::parse('1397-09-11 21:32:35');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('1 سال بعد', $difference);
    }

    public function testFormatWord()
    {
        $datetime = Jalali::parse('1398-10-11 21:32:35')->formatWord('l d S F');

        $this->assertEquals('چهارشنبه یازده ام دی', $datetime);
    }

    public function testFormatQuarter()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $this->assertEquals('زمستان', $datetime->format('Q'));
        $this->assertEquals(4, $datetime->format('q'));
    }
}
