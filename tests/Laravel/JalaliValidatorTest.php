<?php

namespace Hekmatinasser\Verta\Tests\Laravel\JalaliValidatorTest;

use PHPUnit\Framework\TestCase;
use Hekmatinasser\Verta\Laravel\JalaliValidator;

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

    /** @test */
    public function validateDateWhenSecondArgIsArray()
    {
        $this->assertFalse(
            $this->jalaliValidator->validateDate(NULL, [], [])
        );
    }


    /** @test */
    public function validateDateEqualWhenSecondArgIsArray()
    {
        $this->assertFalse(
            $this->jalaliValidator->validateDateEqual(NULL, [], [])
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

    /**
     * @test
     */
    public function validateDateEqualByIncorrectInput()
    {

        $result = $this->jalaliValidator->validateDateEqual(
            NULL,
            '1397/01/01',
            ['1397/01/02']
        );

        $this->assertFalse($result);
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
}
