<?php

namespace Hekmatinasser\Verta\Tests;

use DateTime;
use Hekmatinasser\Verta\Verta;
use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase
{
    public function testSetFormat()
    {
        Verta::setStringFormat('Y-m-d-H-i-s');
        $datetime = (string) Verta::parse('1398-10-10 22:30:50');

        $this->assertEquals('1398-10-10-22-30-50', $datetime);


        Verta::resetStringFormat();
        $datetime = (string) Verta::parse('1398-10-10 22:30:50');

        $this->assertEquals('1398-10-10 22:30:50', $datetime);

    }

    public function testFormat()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50')->format('y-n-j-g-i-s');

        $this->assertEquals('98-10-10-9-30-50', $datetime);
    }

    public function testFormatGregorian()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50')->formatGregorian('o n j g i s');

        $this->assertEquals('2020 12 31 9 30 50', $datetime);
    }

    public function testFormatDatetime()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50')->formatDatetime();

        $this->assertEquals('1398-10-10 21:30:50', $datetime);
    }

    public function testFormatDate()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50')->formatDate();

        $this->assertEquals('1398-10-10', $datetime);
    }

    public function testFormatTime()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50')->formatTime();

        $this->assertEquals('21:30:50', $datetime);
    }

    public function testFormatJalaliDatetime()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50')->formatJalaliDatetime();

        $this->assertEquals('1398/10/10 21:30:50', $datetime);
    }

    public function testFormatJalaliDate()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50')->formatJalaliDate();

        $this->assertEquals('1398/10/10', $datetime);
    }

    public function testFormatDifference()
    {
        $target = Verta::parse('1398-10-10 21:30:50');

        $datetime = Verta::parse('1398-10-10 21:30:50');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('الان', $difference);

        $datetime = Verta::parse('1398-10-10 21:30:45');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('5 ثانیه بعد', $difference);

        $datetime = Verta::parse('1398-10-10 21:31:58');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('1 دقیقه قبل', $difference);

        $datetime = Verta::parse('1398-10-10 20:30:35');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('1 ساعت بعد', $difference);

        $datetime = Verta::parse('1398-10-11 21:32:35');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('1 روز قبل', $difference);

        $datetime = Verta::parse('1398-11-11 21:32:35');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('1 ماه قبل', $difference);

        $datetime = Verta::parse('1397-09-11 21:32:35');
        $difference = $target->formatDifference($datetime);

        $this->assertEquals('1 سال بعد', $difference);

    }

    public function testFormatWord()
    {
        $datetime = Verta::parse('1398-10-11 21:32:35')->formatWord('l dS F');

        $this->assertEquals('چهارشنبه یازده ام دی', $datetime);
    }
}
