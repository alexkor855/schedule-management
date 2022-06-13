<?php

namespace Tests\Unit;

use App\Models\Enums\TimeStepEnum;
use App\Rules\TimeStep;
use PHPUnit\Framework\TestCase;

class TimeStepTest extends TestCase
{
    /**
     * Tests exception
     *
     * @return void
     */
    public function testException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $validator = new TimeStep(2);
        $validator->passes('', '08:00');
    }

    /**
     * Tests one minute time step
     *
     * @return void
     */
    public function testOneMinute()
    {
        $validator = new TimeStep(TimeStepEnum::OneMinute->value);

        $this->assertTrue($validator->passes('', '08:00'));
        $this->assertTrue($validator->passes('', '08:01'));
        $this->assertTrue($validator->passes('', '08:05'));
        $this->assertTrue($validator->passes('', '08:10'));
        $this->assertTrue($validator->passes('', '08:15'));
        $this->assertTrue($validator->passes('', '08:20'));
        $this->assertTrue($validator->passes('', '08:25'));
        $this->assertTrue($validator->passes('', '08:30'));
        $this->assertTrue($validator->passes('', '08:31'));
        $this->assertTrue($validator->passes('', '08:40'));
        $this->assertTrue($validator->passes('', '08:45'));
        $this->assertTrue($validator->passes('', '08:50'));
    }

    /**
     * Tests five minutes time step
     *
     * @return void
     */
    public function testFiveMinutes()
    {
        $validator = new TimeStep(TimeStepEnum::FiveMinutes->value);

        $this->assertTrue($validator->passes('', '08:00'));
        $this->assertFalse($validator->passes('', '08:01'));
        $this->assertTrue($validator->passes('', '08:05'));
        $this->assertTrue($validator->passes('', '08:10'));
        $this->assertTrue($validator->passes('', '08:15'));
        $this->assertTrue($validator->passes('', '08:20'));
        $this->assertTrue($validator->passes('', '08:25'));
        $this->assertTrue($validator->passes('', '08:30'));
        $this->assertFalse($validator->passes('', '08:31'));
        $this->assertTrue($validator->passes('', '08:40'));
        $this->assertTrue($validator->passes('', '08:45'));
        $this->assertTrue($validator->passes('', '08:50'));
    }

    /**
     * Tests five minutes time step
     *
     * @return void
     */
    public function testTenMinutes()
    {
        $validator = new TimeStep(TimeStepEnum::TenMinutes->value);

        $this->assertTrue($validator->passes('', '08:00'));
        $this->assertFalse($validator->passes('', '08:01'));
        $this->assertFalse($validator->passes('', '08:05'));
        $this->assertTrue($validator->passes('', '08:10'));
        $this->assertFalse($validator->passes('', '08:15'));
        $this->assertTrue($validator->passes('', '08:20'));
        $this->assertFalse($validator->passes('', '08:25'));
        $this->assertTrue($validator->passes('', '08:30'));
        $this->assertFalse($validator->passes('', '08:31'));
        $this->assertTrue($validator->passes('', '08:40'));
        $this->assertFalse($validator->passes('', '08:45'));
        $this->assertTrue($validator->passes('', '08:50'));
    }

    /**
     * Tests five minutes time step
     *
     * @return void
     */
    public function testFifteenMinutes()
    {
        $validator = new TimeStep(TimeStepEnum::FifteenMinutes->value);

        $this->assertTrue($validator->passes('', '08:00'));
        $this->assertFalse($validator->passes('', '08:01'));
        $this->assertFalse($validator->passes('', '08:05'));
        $this->assertFalse($validator->passes('', '08:10'));
        $this->assertTrue($validator->passes('', '08:15'));
        $this->assertFalse($validator->passes('', '08:20'));
        $this->assertFalse($validator->passes('', '08:25'));
        $this->assertTrue($validator->passes('', '08:30'));
        $this->assertFalse($validator->passes('', '08:31'));
        $this->assertFalse($validator->passes('', '08:40'));
        $this->assertTrue($validator->passes('', '08:45'));
        $this->assertFalse($validator->passes('', '08:50'));
    }

    /**
     * Tests five minutes time step
     *
     * @return void
     */
    public function testTwentyMinutes()
    {
        $validator = new TimeStep(TimeStepEnum::TwentyMinutes->value);

        $this->assertTrue($validator->passes('', '08:00'));
        $this->assertFalse($validator->passes('', '08:01'));
        $this->assertFalse($validator->passes('', '08:05'));
        $this->assertFalse($validator->passes('', '08:10'));
        $this->assertFalse($validator->passes('', '08:15'));
        $this->assertTrue($validator->passes('', '08:20'));
        $this->assertFalse($validator->passes('', '08:25'));
        $this->assertFalse($validator->passes('', '08:30'));
        $this->assertFalse($validator->passes('', '08:31'));
        $this->assertTrue($validator->passes('', '08:40'));
        $this->assertFalse($validator->passes('', '08:45'));
        $this->assertFalse($validator->passes('', '08:50'));
    }

    /**
     * Tests five minutes time step
     *
     * @return void
     */
    public function testThirtyMinutes()
    {
        $validator = new TimeStep(TimeStepEnum::ThirtyMinutes->value);

        $this->assertTrue($validator->passes('', '08:00'));
        $this->assertFalse($validator->passes('', '08:01'));
        $this->assertFalse($validator->passes('', '08:05'));
        $this->assertFalse($validator->passes('', '08:10'));
        $this->assertFalse($validator->passes('', '08:15'));
        $this->assertFalse($validator->passes('', '08:20'));
        $this->assertFalse($validator->passes('', '08:25'));
        $this->assertTrue($validator->passes('', '08:30'));
        $this->assertFalse($validator->passes('', '08:31'));
        $this->assertFalse($validator->passes('', '08:40'));
        $this->assertFalse($validator->passes('', '08:45'));
        $this->assertFalse($validator->passes('', '08:50'));
    }

    /**
     * Tests five minutes time step
     *
     * @return void
     */
    public function testSixtyMinutes()
    {
        $validator = new TimeStep(TimeStepEnum::SixtyMinutes->value);

        $this->assertTrue($validator->passes('', '08:00'));
        $this->assertFalse($validator->passes('', '08:01'));
        $this->assertFalse($validator->passes('', '08:05'));
        $this->assertFalse($validator->passes('', '08:10'));
        $this->assertFalse($validator->passes('', '08:15'));
        $this->assertFalse($validator->passes('', '08:20'));
        $this->assertFalse($validator->passes('', '08:25'));
        $this->assertFalse($validator->passes('', '08:30'));
        $this->assertFalse($validator->passes('', '08:31'));
        $this->assertFalse($validator->passes('', '08:40'));
        $this->assertFalse($validator->passes('', '08:45'));
        $this->assertFalse($validator->passes('', '08:50'));
    }
}
