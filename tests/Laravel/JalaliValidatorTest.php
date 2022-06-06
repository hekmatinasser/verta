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
