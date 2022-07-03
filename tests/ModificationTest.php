<?php

namespace Hekmatinasser\Jalali\Tests;

use Hekmatinasser\Jalali\Jalali;
use PHPUnit\Framework\TestCase;

class ModificationTest extends TestCase
{
    public function testAddYears()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $datetime->addYears(2);

        $this->assertEquals('1400-10-10 21:30:50', $datetime->format('Y-m-d H:i:s'));
    }

    public function testSubYears()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $datetime->subYears(3);

        $this->assertEquals('1395-10-10 21:30:50', $datetime->format('Y-m-d H:i:s'));
    }

    public function testAddMonths()
    {
        $datetime = Jalali::parse('1398-10-30 21:30:50');

        $result = $datetime->addMonths(2)->format('Y-m-d H:i:s');

        $this->assertEquals('1398-12-29 21:30:50', $result);
    }

    public function testSubMonths()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->subMonths(3)->format('Y-m-d H:i:s');

        $this->assertEquals('1398-07-10 21:30:50', $result);
    }

    public function testAddWeeks()
    {
        $datetime = Jalali::parse('1398-10-30 21:30:50');

        $result = $datetime->addWeeks(2)->format('Y-m-d H:i:s');

        $this->assertEquals('1398-11-14 21:30:50', $result);
    }

    public function testSubWeeks()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->subWeeks(3)->format('Y-m-d H:i:s');

        $this->assertEquals('1398-09-19 21:30:50', $result);
    }

    public function testAddDays()
    {
        $datetime = Jalali::parse('1398-10-30 21:30:50');

        $result = $datetime->addDays(20)->format('Y-m-d H:i:s');

        $this->assertEquals('1398-11-20 21:30:50', $result);
    }

    public function testSubDays()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->subDays(7)->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-03 21:30:50', $result);
    }

    public function testAddHours()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->addHour()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-10 22:30:50', $result);
    }

    public function testSubHours()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->subHour()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-10 20:30:50', $result);
    }

    public function testAddMinutes()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->addMinutes(6)->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-10 21:36:50', $result);
    }

    public function testSubMinutes()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->subMinute()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-10 21:29:50', $result);
    }

    public function testAddSeconds()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->addSeconds(16)->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-10 21:31:06', $result);
    }

    public function testSubSeconds()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:20');

        $result = $datetime->subSeconds(30)->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-10 21:29:50', $result);
    }

    public function testStartMinute()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->startMinute()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-10 21:30:00', $result);
    }

    public function testStartDay()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->startDay()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-10 00:00:00', $result);
    }

    public function testEndDay()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:20');

        $result = $datetime->endDay()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-10 23:59:59', $result);
    }

    public function testStartWeek()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->startWeek()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-07 00:00:00', $result);
    }

    public function testEndWeek()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:20');

        $result = $datetime->endWeek()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-13 23:59:59', $result);
    }

    public function testStartMonth()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->startMonth()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-01 00:00:00', $result);
    }

    public function testEndMonth()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:20');

        $result = $datetime->endMonth()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-30 23:59:59', $result);
    }

    public function testStartQuarter()
    {
        $datetime = Jalali::parse('1398-11-10 21:30:50');

        $result = $datetime->startQuarter()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-10-01 00:00:00', $result);
    }

    public function testEndQuarter()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:20');

        $result = $datetime->endQuarter()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-12-29 23:59:59', $result);
    }

    public function testStartYear()
    {
        $datetime = Jalali::parse('1398-11-10 21:30:50');

        $result = $datetime->startYear()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-01-01 00:00:00', $result);
    }

    public function testEndYear()
    {
        $datetime = Jalali::parse('1398-10-15 21:30:20');

        $result = $datetime->endYear()->format('Y-m-d H:i:s');

        $this->assertEquals('1398-12-29 23:59:59', $result);
    }
}
