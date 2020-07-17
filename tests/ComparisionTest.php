<?php

namespace Hekmatinasser\Verta\Tests;

use Hekmatinasser\Verta\Verta;
use PHPUnit\Framework\TestCase;

class ComparisionTest extends TestCase
{
    public function testValidDate()
    {
        $result = Verta::isValidDate(1365, 12, 15);
        $this->assertTrue($result);

        $result = Verta::isValidDate(-1365, 12, 15);
        $this->assertFalse($result);

        $result = Verta::isValidDate(1365, 13, 15);
        $this->assertFalse($result);

        $result = Verta::isValidDate(1365, 12, 32);
        $this->assertFalse($result);
    }

    public function testValidTime()
    {
        $result = Verta::isValidTime(13, 12, 15);
        $this->assertTrue($result);

        $result = Verta::isValidTime(25, 12, 15);
        $this->assertFalse($result);

        $result = Verta::isValidTime(14, 65, 15);
        $this->assertFalse($result);

        $result = Verta::isValidTime(14, 12, 66);
        $this->assertFalse($result);
    }

    public function testDiffYears()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->diffYears(Verta::parse('1398-10-10 21:30:50'));
        $this->assertEquals(0, $result);

        $result = $datetime->diffYears(Verta::parse('1395-10-10 21:30:50'));
        $this->assertEquals(-3, $result);

        $result = $datetime->diffYears(Verta::parse('1399-10-11 21:30:50'));
        $this->assertEquals(1, $result);
    }

    public function testDiffMonths()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $datetime = Verta::parse('1398-10-10 21:30:50');
        $result = $datetime->diffMonths($datetime);

        $this->assertEquals(0, $result);

        $result = $datetime->diffMonths(Verta::parse('1399-12-15 21:30:50'));
        $this->assertEquals(14, $result);

        $result = $datetime->diffMonths(Verta::parse('1397-08-10 21:30:50'));
        $this->assertEquals(-13, $result);
    }

    public function testDiffDays()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->diffDays(Verta::parse('1398-10-10 21:30:50'));
        $this->assertEquals(0, $result);

        $result = $datetime->diffDays(Verta::parse('1398-10-15 21:30:50'));
        $this->assertEquals(5, $result);

        $result = $datetime->diffDays(Verta::parse('1398-10-01 21:30:50'));
        $this->assertEquals(-9, $result);
    }

    public function testDiffHours()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->diffHours(Verta::parse('1398-10-10 21:30:50'));
        $this->assertEquals(0, $result);

        $result = $datetime->diffHours(Verta::parse('1398-10-10 23:30:50'));
        $this->assertEquals(2, $result);

        $result = $datetime->diffHours(Verta::parse('1398-10-10 20:30:50'));
        $this->assertEquals(-1, $result);
    }

    public function testDiffMinutes()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->diffMinutes(Verta::parse('1398-10-10 21:30:50'));
        $this->assertEquals(0, $result);

        $result = $datetime->diffMinutes(Verta::parse('1398-10-10 21:40:50'));
        $this->assertEquals(10, $result);

        $result = $datetime->diffMinutes(Verta::parse('1398-10-10 20:30:50'));
        $this->assertEquals(-60, $result);
    }

    public function testDiffSeconds()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->diffSeconds(Verta::parse('1398-10-10 21:30:50'));
        $this->assertEquals(0, $result);

        $result = $datetime->diffSeconds(Verta::parse('1398-10-10 21:30:53'));
        $this->assertEquals(3, $result);


        $result = $datetime->diffSeconds(Verta::parse('1398-10-10 21:30:45'));
        $this->assertEquals(-5, $result);
    }

    public function testEqualTo()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->eq(Verta::parse('1398-10-10 21:30:50'));
        $this->assertTrue($result);

        $result = $datetime->eq(Verta::parse('1398-10-10 21:30:51'));
        $this->assertFalse($result);
    }

    public function testGreaterThan()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->gt(Verta::parse('1398-10-10 21:30:50'));
        $this->assertFalse($result);

        $result = $datetime->gt(Verta::parse('1398-10-10 21:30:49'));
        $this->assertTrue($result);
    }

    public function testGreaterThanOrEqualTo()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->gte(Verta::parse('1398-10-10 21:30:50'));
        $this->assertTrue($result);

        $result = $datetime->gte(Verta::parse('1398-10-10 21:30:49'));
        $this->assertTrue($result);

        $result = $datetime->gte(Verta::parse('1398-10-10 21:30:51'));
        $this->assertFalse($result);
    }

    public function testLessThan()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->lt(Verta::parse('1398-10-10 21:30:50'));
        $this->assertFalse($result);

        $result = $datetime->lt(Verta::parse('1398-10-10 21:30:51'));
        $this->assertTrue($result);
    }

    public function testLessThanOrEqualTo()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->lte(Verta::parse('1398-10-10 21:30:50'));
        $this->assertTrue($result);

        $result = $datetime->lte(Verta::parse('1398-10-10 21:30:51'));
        $this->assertTrue($result);


        $result = $datetime->lte(Verta::parse('1398-10-10 21:30:49'));
        $this->assertFalse($result);
    }

    public function testBetween()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result =  $datetime->between(Verta::parse('1398-10-10 21:30:50'), Verta::parse('1398-10-11 21:30:50'));
        $this->assertTrue($result);

        $result =  $datetime->between(Verta::parse('1398-10-10 21:30:50'), Verta::parse('1398-10-11 21:30:50'), false);
        $this->assertFalse($result);

        $result =  $datetime->between(Verta::parse('1398-10-13 21:30:50'), Verta::parse('1398-10-09 21:30:50'));
        $this->assertTrue($result);
    }

    public function testClosest()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result =  $datetime->closest(Verta::parse('1398-10-10 21:30:01'), Verta::parse('1398-10-11 21:30:50'));
        $this->assertEquals($result, Verta::parse('1398-10-10 21:30:01'));

        $result =  $datetime->closest(Verta::parse('1398-11-10 21:30:50'), Verta::parse('1398-10-11 21:30:50'));
        $this->assertEquals($result, Verta::parse('1398-10-11 21:30:50'));
    }

    public function testFarthest()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->farthest(Verta::parse('1398-10-10 21:30:01'), Verta::parse('1398-10-11 21:30:50'));
        $this->assertEquals($result, Verta::parse('1398-10-11 21:30:50'));

        $result = $datetime->farthest(Verta::parse('1398-11-10 21:30:50'), Verta::parse('1398-10-11 21:30:50'));
        $this->assertEquals($result, Verta::parse('1398-11-10 21:30:50'));
    }

    public function testMin()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->min(Verta::parse('1398-10-10 21:30:01'));
        $this->assertEquals($result, Verta::parse('1398-10-10 21:30:01'));

        $result = $datetime->min(Verta::parse('1398-10-10 21:30:55'));
        $this->assertEquals($result, Verta::parse('1398-10-10 21:30:50'));
    }

    public function testMax()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');

        $result = $datetime->max(Verta::parse('1398-10-10 21:30:01'));
        $this->assertEquals($result, Verta::parse('1398-10-10 21:30:50'));

        $result = $datetime->max(Verta::parse('1398-10-10 21:30:55'));
        $this->assertEquals($result, Verta::parse('1398-10-10 21:30:55'));
    }

    public function testIsDay()
    {
        $datetime = Verta::parse('1397-10-10 21:30:50');
        $target = Verta::parse('1398-10-10 21:30:01');

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
        $this->assertFalse($datetime->isCurrentMonth());
        $this->assertFalse($datetime->isSameMonth());
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
