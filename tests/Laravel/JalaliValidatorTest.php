<?php

namespace Hekmatinasser\Verta\Tests\Laravel\JalaliValidatorTest;

use PHPUnit\Framework\TestCase;
use Hekmatinasser\Verta\Laravel\JalaliValidator;
use Hekmatinasser\Verta\Verta;

class JalaliValidatorTest extends TestCase
{

    protected JalaliValidator $jalaliValidator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jalaliValidator = new JalaliValidator;
    }

    /**
     * @test
     * @dataProvider correctDateFormatProvider
     */
    public function validateDateByCorrectInput($date, $format = null)
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDate(NULL, $date, !!$format ? [$format] : [])
        );
    }

    /**
     * @test
     * @dataProvider incorrectDateFormatProvider
     */
    public function validateDateByIncorrectInput($date, $format = null)
    {
        $this->assertFalse(
            $this->jalaliValidator->validateDate(NULL, $date, !!$format ? [$format] : [])
        );
    }

    /**
     * @test
     * @dataProvider correctDateFormatProvider
     */
    public function validateDateEqualByCorrectInput($date, $format = null)
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDateEqual(
                NULL,
                $date,
                !!$format ? [$date, $format] : [$date]
            )
        );
    }

    /** @test */
    public function validateDateEqualByIncorrectInput()
    {

        $result = $this->jalaliValidator->validateDateEqual(
            NULL,
            '1397/01/01',
            ['1397/01/02']
        );

        $this->assertFalse($result);
    }

    /** @test */
    public function validateDateNotEqual()
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDateNotEqual(NULL,  '1399/01/01', ['1399/01/02'])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateNotEqual(NULL, '1399/01/01', ['1399/01/01'])
        );
    }


    /***
     * provider for tests
     */
    public function correctDateFormatProvider()
    {
        return [
            [
                "1398/01/01",
                "Y/m/d"
            ],
            [
                "1398/01/01",
            ],
            [
                "1398-01-01",
                "Y-m-d"
            ],
            [
                "1398-01-01 20:00:00",
                "Y-m-d H:i:s"
            ],
            [
                "1398-01-01 20:00",
                "Y-m-d H:i"
            ],
            [
                "1398.12.29",
                "Y.m.d"
            ],
        ];
    }

    /**
     * provider for tests
     */
    public function incorrectDateFormatProvider()
    {
        return [
            [
                "1398",
                "Y"
            ],
            [
                "1398-01",
                "Y-m"
            ],
            [
                "1398/01",
                "Y/m"
            ]
        ];
    }

    /**
     * provider for tests
     */
    public function jalaliValidatorMethods()
    {
        return [
            ["validateDate"],
            ["validateDateEqual"],
            ["validateDateNotEqual"],
            ["validateDateTime"],
            ["validateDateTimeEqual"],
            ["validateDateTimeNotEqual"],
            ["validateDateAfterEqual"],
            ["validateDateTimeAfter"],
            ["validateDateTimeAfterEqual"],
            ["validateDateBeforeEqual"],
            ["validateDateTimeBefore"],
            ["validateDateTimeBeforeEqual"],
        ];
    }

    /**
     * @test
     * @dataProvider jalaliValidatorMethods
     */
    public function whenJalaliValidatorSecoundArgumentIsEmpty($method)
    {
        $this->assertFalse(
            $this->jalaliValidator->{$method}(NULL, [], [])
        );
    }

    /** @test */
    public function validateDateTime()
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDateTime(NULL, "1398/01/01 20:00:00", [])
        );

        $this->assertTrue(
            $this->jalaliValidator->validateDateTime(NULL, "1398/01/01 20:00:00", ["Y/m/d H:i:s"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateTime(NULL, "1398/01/01", ["Y/m/d H:i:s"])
        );
    }

    /** @test */
    public function validateDateTimeEqual()
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDateTimeEqual(NULL, "1398/01/01 20:00:00", ["1398/01/01 20:00:00"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateTimeEqual(NULL, "1398/01/01 20:00:00", ["1398/01/01 20:00:01"])
        );
    }

    /** @test */
    public function validateDateTimeNotEqual()
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDateTimeNotEqual(NULL, "1398/01/01 20:00:00", ["1398/01/01 20:00:01"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateTimeNotEqual(NULL, "1398/01/01 20:00:00", ["1398/01/01 20:00:00"])
        );
    }

    /** @test */
    public function validateDateAfter()
    {

        $this->assertTrue(
            $this->jalaliValidator->validateDateAfter(NULL, "1398/01/02", ["1398/01/01"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateAfter(NULL, "1398/01/01", ["1398/01/01"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateAfter(NULL, "1398/01/01", ["1398/01/02"])
        );
    }

    /** @test */
    public function validateDateAfterEqual()
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDateAfterEqual(NULL, "1398/01/02", ["1398/01/01"])
        );

        $this->assertTrue(
            $this->jalaliValidator->validateDateAfterEqual(NULL, "1398/01/01", ["1398/01/01"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateAfterEqual(NULL, "1398/01/01", ["1398/01/02"])
        );
    }

    /** @test */
    public function validateDateTimeAfter()
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDateTimeAfter(NULL, "1398/01/02 20:00:00", ["1398/01/01 20:00:00"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateTimeAfter(NULL, "1398/01/01 20:00:00", ["1398/01/01 20:00:00"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateTimeAfter(NULL, "1398/01/01 20:00:00", ["1398/01/02 20:00:00"])
        );
    }

    /** @test */
    public function validateDateTimeAfterEqual()
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDateTimeAfterEqual(NULL, "1398/01/02 20:00:00", ["1398/01/01 20:00:00"])
        );

        $this->assertTrue(
            $this->jalaliValidator->validateDateTimeAfterEqual(NULL, "1398/01/01 20:00:00", ["1398/01/01 20:00:00"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateTimeAfterEqual(NULL, "1398/01/01 20:00:00", ["1398/01/02 20:00:00"])
        );
    }

    /** @test */
    public function validateDateBefore()
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDateBefore(NULL, "1398/01/01", ["1398/01/02"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateBefore(NULL, "1398/01/01", ["1398/01/01"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateBefore(NULL, "1398/01/02", ["1398/01/01"])
        );
    }

    /** @test */
    public function validateDateBeforeEqual()
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDateBeforeEqual(NULL, "1398/01/01", ["1398/01/02"])
        );

        $this->assertTrue(
            $this->jalaliValidator->validateDateBeforeEqual(NULL, "1398/01/01", ["1398/01/01"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateBeforeEqual(NULL, "1398/01/05", ["1398/01/01"])
        );
    }

    /** @test */
    public function validateDateTimeBefore()
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDateTimeBefore(NULL, "1398/01/01 20:00:00", ["1398/01/02 20:00:00"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateTimeBefore(NULL, "1398/01/01 20:00:00", ["1398/01/01 20:00:00"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateTimeBefore(NULL, "1398/01/02 20:00:00", ["1398/01/01 20:00:00"])
        );
    }

    /** @test */
    public function validateDateTimeBeforeEqual()
    {
        $this->assertTrue(
            $this->jalaliValidator->validateDateTimeBeforeEqual(NULL, "1398/01/01 20:00:00", ["1398/01/02 20:00:00"])
        );

        $this->assertTrue(
            $this->jalaliValidator->validateDateTimeBeforeEqual(NULL, "1398/01/01 20:00:00", ["1398/01/01 20:00:00"])
        );

        $this->assertFalse(
            $this->jalaliValidator->validateDateTimeBeforeEqual(NULL, "1398/01/02 20:00:00", ["1398/01/01 20:00:00"])
        );
    }

    /** @test */
    public function replaceDateOrDatetime()
    {
        $text = "hello world!";
        $result = $this->jalaliValidator->replaceDateOrDatetime($text, NULL, NULL, NULL);
        $this->assertEquals($text, $result);
    }

    /** @test */
    public function replaceDateAfterOrBeforeOrEqual()
    {
        $message = "The :attribute is not equal Jalali date  :date";
        Verta::setLocale("en");
        $result = $this->jalaliValidator->replaceDateAfterOrBeforeOrEqual($message, NULL, NULL, [$date = "1398/01/01", "Y-m-d"]);
        $this->assertEquals("The :attribute is not equal Jalali date  {$date}", $result);
        Verta::setLocale("fa");
        $result = $this->jalaliValidator->replaceDateAfterOrBeforeOrEqual($message, NULL, NULL, [$date = "1398/01/01", "Y-m-d"]);
        $this->assertEquals("The :attribute is not equal Jalali date  ۱۳۹۸/۰۱/۰۱", $result);
    }
}
