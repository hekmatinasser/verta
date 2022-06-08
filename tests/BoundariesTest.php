<?php

namespace Hekmatinasser\Verta\Tests;

use Hekmatinasser\Verta\Verta;
use PHPUnit\Framework\TestCase;

class BoundariesTest extends TestCase
{
    /** @test */
    public function startMinute()
    {
        $datetime = Verta::parse('1398-10-10 21:30:50');
        $result = $datetime->startMinute()->format('Y-m-d H:i:s');
        $this->assertEquals('1398-10-10 21:30:00', $result);
        $this->assertEquals(1577827800, $datetime->timestamp);
    }

    /** @test */
    public function endMinute()
    {
        $datetime = Verta::parse('1398-10-10 21:30:00');
        $result = $datetime->endMinute()->format('Y-m-d H:i:s');
        $this->assertEquals('1398-10-10 21:30:59', $result);
        $this->assertEquals(1577827859, $datetime->timestamp);
    }

    /** @test */
    public function startHour()
    {
        $datetime = Verta::parse('1398-10-10 21:30:59');
        $result = $datetime->startHour()->format('Y-m-d H:i:s');
        $this->assertEquals('1398-10-10 21:00:00', $result);
        $this->assertEquals(1577826000, $datetime->timestamp);
    }

    /** @test */
    public function endHour()
    {
        $datetime = Verta::parse('1398-10-10 21:30:59');
        $result = $datetime->endHour()->format('Y-m-d H:i:s');
        $this->assertEquals('1398-10-10 21:59:59', $result);
        $this->assertEquals(1577829599, $datetime->timestamp);
    }
}
