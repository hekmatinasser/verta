<?php

namespace Hekmatinasser\Verta\Tests;

use Hekmatinasser\Verta\Verta;
use PHPUnit\Framework\TestCase;

class CheckTest extends TestCase
{

    public function testIsLeapYear()
    {
        $leap_years = [1375, 1379, 1383, 1387, 1391, 1395, 1399, 1403, 1408, 1412, 1416, 1420];

        for ($year = 1372; $year < 1422; $year++) {
            $this->assertEquals(in_array($year, $leap_years), Verta::isLeapYear($year));
        }

    }

    public function testIsValidDate()
    {

        $this->assertTrue(Verta::isValidDate(1399, 12, 30));
        $this->assertTrue(Verta::isValidDate(1412, 12, 30));
        $this->assertFalse(Verta::isValidDate(1398, 12, 30));
        $this->assertFalse(Verta::isValidDate(1401, 12, 30));

        $this->assertFalse(Verta::isValidDate(1401, 11, 31));
        $this->assertFalse(Verta::isValidDate(1401, 07, 31));
        $this->assertFalse(Verta::isValidDate(1399, 12, 31));

        $this->assertFalse(Verta::isValidDate(1399, 13, 30));

        $this->assertTrue(Verta::isValidDate(1399, 01, 31));
        $this->assertTrue(Verta::isValidDate(1399, 06, 31));

        $this->assertTrue(Verta::isValidDate('1399', '06', '31'));

    }

    public function testIsValidTime()
    {
        $this->assertTrue(Verta::isValidTime(12, 50, 30));
        $this->assertTrue(Verta::isValidTime(12, 50, 0));

        $this->assertFalse(Verta::isValidTime(24, 50, 30));
        $this->assertFalse(Verta::isValidTime(1, 50, 60));

        $this->assertTrue(Verta::isValidTime(1, 0, 30));
        $this->assertTrue(Verta::isValidTime(0, 0, 0));
        $this->assertTrue(Verta::isValidTime(23, 59, 59));

    }


}
