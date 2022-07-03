<?php

namespace Hekmatinasser\Jalali\Tests;

use Hekmatinasser\Jalali\Jalali;
use PHPUnit\Framework\TestCase;

class ComparisonTest extends TestCase
{
    public function testValidDate()
    {
        $result = Jalali::isValidDate(1365, 12, 15);
        $this->assertTrue($result);

        $result = Jalali::isValidDate(-1365, 12, 15);
        $this->assertFalse($result);

        $result = Jalali::isValidDate(1365, 13, 15);
        $this->assertFalse($result);

        $result = Jalali::isValidDate(1365, 12, 32);
        $this->assertFalse($result);
    }

    public function testValidTime()
    {
        $result = Jalali::isValidTime(13, 12, 15);
        $this->assertTrue($result);

        $result = Jalali::isValidTime(25, 12, 15);
        $this->assertFalse($result);

        $result = Jalali::isValidTime(14, 65, 15);
        $this->assertFalse($result);

        $result = Jalali::isValidTime(14, 12, 66);
        $this->assertFalse($result);
    }

    public function testDiffYears()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->diffYears(Jalali::parse('1398-10-10 21:30:50'));
        $this->assertEquals(0, $result);

        $result = $datetime->diffYears(Jalali::parse('1395-10-10 21:30:50'));
        $this->assertEquals(-3, $result);

        $result = $datetime->diffYears(Jalali::parse('1399-10-11 21:30:50'));
        $this->assertEquals(1, $result);
    }

    public function testDiffMonths()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');
        $result = $datetime->diffMonths($datetime);

        $this->assertEquals(0, $result);

        $result = $datetime->diffMonths(Jalali::parse('1399-12-15 21:30:50'));
        $this->assertEquals(14, $result);

        $result = $datetime->diffMonths(Jalali::parse('1397-08-10 21:30:50'));
        $this->assertEquals(-13, $result);
    }

    public function testDiffDays()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->diffDays(Jalali::parse('1398-10-10 21:30:50'));
        $this->assertEquals(0, $result);

        $result = $datetime->diffDays(Jalali::parse('1398-10-15 21:30:50'));
        $this->assertEquals(5, $result);

        $result = $datetime->diffDays(Jalali::parse('1398-10-01 21:30:50'));
        $this->assertEquals(-9, $result);
    }

    public function testDiffWeeks()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->diffWeeks(Jalali::parse('1398-10-10 21:30:50'));
        $this->assertEquals(0, $result);

        $result = $datetime->diffWeeks(Jalali::parse('1398-11-15 21:30:50'));
        $this->assertEquals(5, $result);

        $result = $datetime->diffWeeks(Jalali::parse('1398-10-01 21:30:50'));
        $this->assertEquals(-1, $result);
    }

    public function testDiffHours()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->diffHours(Jalali::parse('1398-10-10 21:30:50'));
        $this->assertEquals(0, $result);

        $result = $datetime->diffHours(Jalali::parse('1398-10-10 23:30:50'));
        $this->assertEquals(2, $result);

        $result = $datetime->diffHours(Jalali::parse('1398-10-10 20:30:50'));
        $this->assertEquals(-1, $result);
    }

    public function testDiffMinutes()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->diffMinutes(Jalali::parse('1398-10-10 21:30:50'));
        $this->assertEquals(0, $result);

        $result = $datetime->diffMinutes(Jalali::parse('1398-10-10 21:40:50'));
        $this->assertEquals(10, $result);

        $result = $datetime->diffMinutes(Jalali::parse('1398-10-10 20:30:50'));
        $this->assertEquals(-60, $result);
    }

    public function testDiffSeconds()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->diffSeconds(Jalali::parse('1398-10-10 21:30:50'));
        $this->assertEquals(0, $result);

        $result = $datetime->diffSeconds(Jalali::parse('1398-10-10 21:30:53'));
        $this->assertEquals(3, $result);


        $result = $datetime->diffSeconds(Jalali::parse('1398-10-10 21:30:45'));
        $this->assertEquals(-5, $result);
    }

    public function testEqualTo()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->eq(Jalali::parse('1398-10-10 21:30:50'));
        $this->assertTrue($result);

        $result = $datetime->eq(Jalali::parse('1398-10-10 21:30:51'));
        $this->assertFalse($result);
    }

    public function testNotEqualTo()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->ne(Jalali::parse('1398-10-10 21:30:50'));
        $this->assertFalse($result);

        $result = $datetime->notEqualTo(Jalali::parse('1398-10-10 21:30:51'));
        $this->assertTrue($result);
    }

    public function testGreaterThan()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->gt(Jalali::parse('1398-10-10 21:30:50'));
        $this->assertFalse($result);

        $result = $datetime->greaterThanOrEqualTo(Jalali::parse('1398-10-10 21:30:49'));
        $this->assertTrue($result);
    }

    public function testGreaterThanOrEqualTo()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->gte(Jalali::parse('1398-10-10 21:30:50'));
        $this->assertTrue($result);

        $result = $datetime->gte(Jalali::parse('1398-10-10 21:30:49'));
        $this->assertTrue($result);

        $result = $datetime->gte(Jalali::parse('1398-10-10 21:30:51'));
        $this->assertFalse($result);
    }

    public function testLessThan()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->lt(Jalali::parse('1398-10-10 21:30:50'));
        $this->assertFalse($result);

        $result = $datetime->lt(Jalali::parse('1398-10-10 21:30:51'));
        $this->assertTrue($result);
    }

    public function testLessThanOrEqualTo()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->lte(Jalali::parse('1398-10-10 21:30:50'));
        $this->assertTrue($result);

        $result = $datetime->lessThanOrEqualTo(Jalali::parse('1398-10-10 21:30:51'));
        $this->assertTrue($result);


        $result = $datetime->lte(Jalali::parse('1398-10-10 21:30:49'));
        $this->assertFalse($result);
    }

    public function testBetween()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->between(Jalali::parse('1398-10-10 21:30:50'), Jalali::parse('1398-10-11 21:30:50'));
        $this->assertTrue($result);

        $result = $datetime->between(Jalali::parse('1398-10-10 21:30:50'), Jalali::parse('1398-10-11 21:30:50'), false);
        $this->assertFalse($result);

        $result = $datetime->between(Jalali::parse('1398-10-13 21:30:50'), Jalali::parse('1398-10-09 21:30:50'));
        $this->assertTrue($result);
    }

    public function testClosest()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->closest(Jalali::parse('1398-10-10 21:30:01'), Jalali::parse('1398-10-11 21:30:50'));
        $this->assertEquals($result, Jalali::parse('1398-10-10 21:30:01'));

        $result = $datetime->closest(Jalali::parse('1398-11-10 21:30:50'), Jalali::parse('1398-10-11 21:30:50'));
        $this->assertEquals($result, Jalali::parse('1398-10-11 21:30:50'));
    }

    public function testFarthest()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->farthest(Jalali::parse('1398-10-10 21:30:01'), Jalali::parse('1398-10-11 21:30:50'));
        $this->assertEquals($result, Jalali::parse('1398-10-11 21:30:50'));

        $result = $datetime->farthest(Jalali::parse('1398-11-10 21:30:50'), Jalali::parse('1398-10-11 21:30:50'));
        $this->assertEquals($result, Jalali::parse('1398-11-10 21:30:50'));
    }

    public function testMin()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->min(Jalali::parse('1398-10-10 21:30:01'));
        $this->assertEquals($result, Jalali::parse('1398-10-10 21:30:01'));

        $result = $datetime->min(Jalali::parse('1398-10-10 21:30:55'));
        $this->assertEquals($result, Jalali::parse('1398-10-10 21:30:50'));
    }

    public function testMax()
    {
        $datetime = Jalali::parse('1398-10-10 21:30:50');

        $result = $datetime->max(Jalali::parse('1398-10-10 21:30:01'));
        $this->assertEquals($result, Jalali::parse('1398-10-10 21:30:50'));

        $result = $datetime->max(Jalali::parse('1398-10-10 21:30:55'));
        $this->assertEquals($result, Jalali::parse('1398-10-10 21:30:55'));
    }

    public function testIs()
    {
        $datetime = Jalali::parse('1397-10-10 21:30:50');
        $target = Jalali::parse('1398-10-10 21:30:01');

//        Jalali::setTestNow('1397-10-10 21:30:50');

        $this->assertTrue($datetime->isWeekday());
        $this->assertFalse($datetime->isWeekend());
        $this->assertFalse($datetime->isYesterday());
        $this->assertFalse($datetime->isToday());
        $this->assertFalse($datetime->isTomorrow());
        $this->assertFalse($datetime->isNextWeek());
        $this->assertFalse($datetime->isLastWeek());
        $this->assertFalse($datetime->isNextMonth());
        $this->assertFalse($datetime->isLastMonth());
        $this->assertFalse($datetime->isNextYear());
        $this->assertFalse($datetime->isLastYear());
        $this->assertFalse($datetime->isFuture());
        $this->assertTrue($datetime->isPast());
        $this->assertTrue($datetime->isSameAs('m-d', $target));
        $this->assertFalse($datetime->isSameAs('Y-m-d'));
        $this->assertFalse($datetime->isCurrentYear());
        $this->assertFalse($datetime->isSameYear($target));
        $this->assertFalse($datetime->isSameDay($target));
        $this->assertTrue($datetime->isBirthday($target));
        $this->assertFalse($datetime->isSaturday());
        $this->assertFalse($datetime->isSunday());
        $this->assertTrue($datetime->isMonday());
        $this->assertFalse($datetime->isTuesday());
        $this->assertFalse($datetime->isWednesday());
        $this->assertFalse($datetime->isThursday());
        $this->assertFalse($datetime->isFriday());
    }
}
