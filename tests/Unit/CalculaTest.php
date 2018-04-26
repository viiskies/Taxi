<?php

namespace App\Tests\Unit;

use App\Service\Calculator;
use PHPUnit\Framework\TestCase;

class CalculaTest extends TestCase
{
    private $calculator;

    protected function setUp()
    {
        parent::setUp();
        
        $this->calculator = new Calculator();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->calculator = null;
    }


    public function testSomething()
    {
        $this->assertTrue(true);
    }

    public function additionDataProvider()
    {
        return [
            [5, 3, 8],
            [8, 12, 20]
        ];
    }

    /**
     * @dataProvider additionDataProvider
     * @param $a
     * @param $b
     * @param $expected
     */
    public function testAddition($a, $b, $expected)
    {
        $result = $this->calculator->add($a, $b);

        $this->assertEquals($expected, $result);
    }

    public function subtractionDataProvider()
    {
        return [
            [1, 2, -1],
            [-3, -5, 2],
            [0, 0, 0]
        ];
    }

    /**
     * @param $a
     * @param $b
     * @param $expected
     * @dataProvider subtractionDataProvider
     */
    public function testSubtraction($a, $b, $expected)
    {
        $result = $this->calculator->subtract($a, $b);

        $this->assertEquals($expected, $result);
    }

    public function testAdditionFailsWithStrings()
    {
        try {
            $this->calculator->add('hello', 'world');
            $this->assertTrue(false);
        }
        catch (\UnexpectedValueException $e) {
            $this->assertTrue(true);
        }
    }


    public function testAdditionFailsWithObjects()
    {
        try {
            $this->calculator->add($this->calculator, $this->calculator);
            $this->assertTrue(false);
        }
        catch (\UnexpectedValueException $e) {
            $this->assertTrue(true);
        }
    }

    public function additionFailDataProvider()
    {
        return [
            ['hello', 'world'],
            [new Calculator(), new Calculator()],
            ['hello', new Calculator()]
        ];
    }

    /**
     * @dataProvider additionFailDataProvider
     */
    public function testAdditionFailsWithBadInputs($a, $b)
    {
        try {
            $this->calculator->add($a, $b);
            $this->assertTrue(false);
        }
        catch (\UnexpectedValueException $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * @dataProvider additionFailDataProvider
     */
    public function testSubtractionFailsWithBadInputs($a, $b)
    {
        try {
            $this->calculator->subtract($a, $b);
            $this->assertTrue(false);
        }
        catch (\UnexpectedValueException $e) {
            $this->assertTrue(true);
        }
    }
}
