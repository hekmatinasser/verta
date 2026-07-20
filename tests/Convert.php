<?php

namespace Tests;

use Carbon\Carbon;
use DateTime;
use Hekmatinasser\Verta\Verta;
use PHPUnit\Framework\TestCase;

class VertaTest extends TestCase {
    /**
     * Test fromCarbon with a Carbon instance.
     */
    public function testFromCarbonWithCarbonInstance(): void {
        $carbon = Carbon::create(2025, 6, 1, 12, 30, 45);
        $verta  = Verta::fromCarbon($carbon);

        $this->assertInstanceOf(Verta::class, $verta);
        $this->assertTrue($verta->isGregorian);       // پرچم باید true باشد
        $this->assertEquals(1404, $verta->getYear()); // 2025-06-01 معادل 1404/03/11
        $this->assertEquals(3, $verta->getMonth());
        $this->assertEquals(11, $verta->getDay());
        $this->assertEquals(12, $verta->getHour());
        $this->assertEquals(30, $verta->getMinute());
        $this->assertEquals(45, $verta->getSecond());

        // ویژگی‌های builder نیز مقداردهی شده‌اند
        $this->assertEquals(1404, $verta->Year);
        $this->assertEquals(3, $verta->Month);
        $this->assertEquals(11, $verta->Day);
    }

    /**
     * Test fromCarbon with null (returns builder with Gregorian flag).
     */
    public function testFromCarbonWithNull(): void {
        $builder = Verta::fromCarbon(null);
        $this->assertInstanceOf(Verta::class, $builder);
        $this->assertTrue($builder->isGregorian); // باید true باشد
        // builder باید خالی باشد (Year و ... null)
        $this->assertNull($builder->Year);
        $this->assertNull($builder->Month);
    }

    /**
     * Test fromJalali with a Verta instance.
     */
    public function testFromJalaliWithVertaInstance(): void {
        $original = Verta::createJalali(1404, 3, 11, 12, 30, 45);
        $cloned   = Verta::fromJalali($original);

        $this->assertInstanceOf(Verta::class, $cloned);
        $this->assertNotSame($original, $cloned); // clone شده
        $this->assertFalse($cloned->isGregorian); // پرچم باید false باشد
        $this->assertEquals(1404, $cloned->getYear());
        $this->assertEquals(3, $cloned->getMonth());
        $this->assertEquals(11, $cloned->getDay());
        $this->assertEquals(12, $cloned->getHour());
        $this->assertEquals(30, $cloned->getMinute());
        $this->assertEquals(45, $cloned->getSecond());

        // ویژگی‌های builder کپی شده‌اند
        $this->assertEquals(1404, $cloned->Year);
        $this->assertEquals(3, $cloned->Month);
    }

    /**
     * Test fromJalali with null (returns plain builder).
     */
    public function testFromJalaliWithNull(): void {
        $builder = Verta::fromJalali(null);
        $this->assertInstanceOf(Verta::class, $builder);
        $this->assertFalse($builder->isGregorian); // باید false باشد
        $this->assertNull($builder->Year);
    }

    /**
     * Test from() with a Verta instance (should return Carbon).
     */
    public function testFromWithVertaReturnsCarbon(): void {
        $verta  = Verta::createJalali(1404, 3, 11, 12, 30, 45);
        $carbon = Verta::from($verta);
        $this->assertInstanceOf(Carbon::class, $carbon);
        $this->assertEquals('2025-06-01 12:30:45', $carbon->toDateTimeString());
    }

    /**
     * Test from() with a Carbon instance (should return Verta with builder).
     */
    public function testFromWithCarbonReturnsVerta(): void {
        $carbon = Carbon::create(2025, 6, 1, 12, 30, 45);
        $verta  = Verta::from($carbon);
        $this->assertInstanceOf(Verta::class, $verta);
        $this->assertTrue($verta->isGregorian);
        $this->assertEquals(1404, $verta->getYear());
        $this->assertEquals(3, $verta->getMonth());
        // builder نیز مقداردهی شده
        $this->assertEquals(1404, $verta->Year);
        $this->assertEquals(3, $verta->Month);
    }

    /**
     * Test from() with a DateTimeInterface (should return Verta with builder).
     */
    public function testFromWithDateTimeInterfaceReturnsVerta(): void {
        $dateTime = new DateTime('2025-06-01 12:30:45');
        $verta    = Verta::from($dateTime);
        $this->assertInstanceOf(Verta::class, $verta);
        $this->assertTrue($verta->isGregorian);
        $this->assertEquals(1404, $verta->getYear());
        $this->assertEquals(3, $verta->getMonth());
    }

    /**
     * Test from() with a Jalali date string (should return Verta).
     */
    public function testFromWithJalaliStringReturnsVerta(): void {
        $verta = Verta::from('1404/03/11 12:30:45');
        $this->assertInstanceOf(Verta::class, $verta);
        $this->assertFalse($verta->isGregorian);
        $this->assertEquals(1404, $verta->getYear());
        $this->assertEquals(3, $verta->getMonth());
        $this->assertEquals(11, $verta->getDay());
        // builder مقداردهی شده
        $this->assertEquals(1404, $verta->Year);
        $this->assertEquals(3, $verta->Month);
    }

    /**
     * Test FluentBuilder: setting values and making with Gregorian flag.
     */
    public function testFluentBuilderGregorian(): void {
        $verta = Verta::fromCarbon()
            ->year(2025)
            ->month(6)
            ->day(1)
            ->hour(10)
            ->minute(20)
            ->second(30)
            ->make()
            ->toJalali();                        // toJalali همان instance را برمی‌گرداند

        $this->assertInstanceOf(Verta::class, $verta);
        $this->assertTrue($verta->isGregorian);
        $this->assertEquals(1404, $verta->getYear());
        $this->assertEquals(3, $verta->getMonth());
        $this->assertEquals(11, $verta->getDay());
        $this->assertEquals(10, $verta->getHour());
        $this->assertEquals(20, $verta->getMinute());
        $this->assertEquals(30, $verta->getSecond());

        // بررسی اینکه ویژگی‌های builder کپی شده‌اند
        $this->assertEquals(2025, $verta->Year); // توجه: Year همچنان میلادی است
        $this->assertEquals(6, $verta->Month);
    }

    /**
     * Test FluentBuilder: setting values and making with Jalali (default).
     */
    public function testFluentBuilderJalali(): void {
        $verta = Verta::fromJalali()
            ->year(1404)
            ->month(3)
            ->day(11)
            ->hour(10)
            ->minute(20)
            ->second(30)
            ->make()
            ->toCarbon(); // تبدیل به Carbon

        $this->assertInstanceOf(Carbon::class, $verta);
        $this->assertEquals('2025-06-01 10:20:30', $verta->toDateTimeString());
    }

    /**
     * Test default values in make() when not set.
     */
    public function testFluentBuilderDefaultValues(): void {
        // فقط سال و ماه را تنظیم می‌کنیم
        $verta = Verta::fromJalali()
            ->year(1404)
            ->month(3)
            ->make();

        $this->assertEquals(1404, $verta->getYear());
        $this->assertEquals(3, $verta->getMonth());
        $this->assertEquals(1, $verta->getDay()); // پیش‌فرض 1
        $this->assertEquals(0, $verta->getHour());
        $this->assertEquals(0, $verta->getMinute());
        $this->assertEquals(0, $verta->getSecond());
    }

    /**
     * Test toCarbon conversion.
     */
    public function testToCarbon(): void {
        $verta  = Verta::createJalali(1404, 3, 11, 12, 30, 45);
        $carbon = $verta->toCarbon();
        $this->assertInstanceOf(Carbon::class, $carbon);
        $this->assertEquals('2025-06-01 12:30:45', $carbon->toDateTimeString());
    }

    /**
     * Test toJalali (should return itself).
     */
    public function testToJalali(): void {
        $verta  = Verta::createJalali(1404, 3, 11);
        $result = $verta->toJalali();
        $this->assertSame($verta, $result);
    }

    /**
     * Test Getters.
     */
    public function testGetters(): void {
        $verta = Verta::createJalali(1404, 3, 11, 12, 30, 45);
        $this->assertEquals(1404, $verta->getYear());
        $this->assertEquals(3, $verta->getMonth());
        $this->assertEquals(11, $verta->getDay());
        $this->assertEquals(12, $verta->getHour());
        $this->assertEquals(30, $verta->getMinute());
        $this->assertEquals(45, $verta->getSecond());

        // getDaysInMonth برای ماه ۳ (خرداد) باید ۳۱ باشد
        $this->assertEquals(31, $verta->getDaysInMonth());

        $parts = $verta->getParts();
        $this->assertEquals([
            'year'   => 1404,
            'month'  => 3,
            'day'    => 11,
            'hour'   => 12,
            'minute' => 30,
            'second' => 45,
        ], $parts);
    }

    /**
     * Test that builder properties are copied to new instance after make().
     */
    public function testBuilderPropertiesCopiedAfterMake(): void {
        $verta = Verta::fromCarbon()
            ->year(2025)
            ->month(6)
            ->day(1)
            ->make();

        $this->assertEquals(2025, $verta->Year);
        $this->assertEquals(6, $verta->Month);
        $this->assertEquals(1, $verta->Day);
        $this->assertEquals(0, $verta->Hour);
        $this->assertEquals(0, $verta->Minute);
        $this->assertEquals(0, $verta->Second);
    }

    /**
     * Test fromCarbon with null returns builder and then make works.
     */
    public function testFromCarbonNullThenMake(): void {
        $verta = Verta::fromCarbon()
            ->year(2025)
            ->month(6)
            ->day(1)
            ->make();

        $this->assertInstanceOf(Verta::class, $verta);
        $this->assertEquals(1404, $verta->getYear());
        $this->assertEquals(3, $verta->getMonth());
    }

    /**
     * Test fromJalali null then make works.
     */
    public function testFromJalaliNullThenMake(): void {
        $verta = Verta::fromJalali()
            ->year(1404)
            ->month(3)
            ->day(11)
            ->make();

        $this->assertInstanceOf(Verta::class, $verta);
        $this->assertEquals(1404, $verta->getYear());
        $this->assertEquals(3, $verta->getMonth());
        $this->assertEquals(11, $verta->getDay());
    }

    /**
     * Test that isGregorian is properly set for different scenarios.
     */
    public function testIsGregorianFlag(): void {
        // از Carbon
        $verta = Verta::fromCarbon(Carbon::now());
        $this->assertTrue($verta->isGregorian);

        // از Jalali
        $verta = Verta::fromJalali(Verta::now());
        $this->assertFalse($verta->isGregorian);

        // از string شمسی
        $verta = Verta::from('1404/03/11');
        $this->assertFalse($verta->isGregorian);

        // از string میلادی (به عنوان تاریخ شمسی تفسیر می‌شود)
        $verta = Verta::from('2025/06/01'); // این به عنوان شمسی تفسیر می‌شود
        $this->assertFalse($verta->isGregorian);
    }

    /**
     * Test conversion with known dates to ensure accuracy.
     */
    public function testKnownDateConversion(): void {
        // 2025-06-01 میلادی معادل 1404-03-11 شمسی
        $carbon = Carbon::create(2025, 6, 1);
        $verta  = new Verta($carbon);
        $this->assertEquals(1404, $verta->getYear());
        $this->assertEquals(3, $verta->getMonth());
        $this->assertEquals(11, $verta->getDay());

        // برعکس
        $verta  = Verta::createJalali(1404, 3, 11);
        $carbon = $verta->toCarbon();
        $this->assertEquals('2025-06-01', $carbon->toDateString());
    }

    /**
     * Test that toCarbon uses timezone property properly.
     */
    public function testToCarbonWithTimezone(): void {
        $verta           = Verta::createJalali(1404, 3, 11, 12, 0, 0);
        $verta->timezone = 'Asia/Tehran';
        $carbon          = $verta->toCarbon();
        $this->assertEquals('Asia/Tehran', $carbon->getTimezone()
            ->getName());
    }
}