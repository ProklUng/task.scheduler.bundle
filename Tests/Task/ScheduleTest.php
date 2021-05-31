<?php

namespace Prokl\TaskSchedulerBundle\Tests\Task;

use Cron\CronExpression;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prokl\TaskSchedulerBundle\Task\Schedule;

/**
 * Class ScheduleTest
 * @package Prokl\TaskSchedulerBundle\Tests\Task
 */
class ScheduleTest extends TestCase
{
    /**
     * @return void
     */
    public function testDefault() : void
    {
        // By default the cron should just run everyday at midnight
        $schedule = new Schedule();

        $this->assertEquals(
            $schedule->getExpression(),
            "* * * * *"
        );
    }

    /**
     * @return void
     */
    public function testHours() : void
    {
        $schedule = new Schedule();
        $schedule->hours(12);


        $this->assertEquals(
            $schedule->getExpression(),
            "* 12 * * *"
        );
    }

    /**
     * @return void
     */
    public function testMinutes() : void
    {
        $schedule = new Schedule();
        $schedule->minutes(12);

        $this->assertEquals(
            $schedule->getExpression(),
            "12 * * * *"
        );
    }

    /**
     * @return void
     */
    public function testEveryXMinutes() : void
    {
        $schedule = new Schedule();
        $schedule->everyMinutes(5);

        $this->assertEquals(
            $schedule->getExpression(),
            "*/5 * * * *"
        );
    }

    /**
     * @return void
     */
    public function testEveryXHours() : void
    {
        $schedule = new Schedule();
        $schedule->everyHours(5);

        $this->assertEquals(
            $schedule->getExpression(),
            "* */5 * * *"
        );
    }

    /**
     * @return void
     */
    public function testDaily() : void
    {
        $schedule = new Schedule("1 2 3 4 5");
        $schedule->daily();

        $this->assertEquals(
            $schedule->getExpression(),
            "1 2 * 4 5"
        );
    }

    /**
     * @return void
     */
    public function testSetExpression() : void
    {
        $schedule = new Schedule("* * * * *");
        $schedule->setExpression("0 * * * *");

        $this->assertEquals(
            $schedule->getExpression(),
            "0 * * * *"
        );
    }

    /**
     * @return void
     */
    public function testSetExpressionAllowedValues() : void
    {
        $schedule = new Schedule("* * 2,7,12 * *");
        $schedule->setExpression("0 8-12 2,7,12 oct sat,sun");

        $this->assertEquals(
            "0 8-12 2,7,12 oct sat,sun",
            $schedule->getExpression()

        );
    }

    /**
     * @return void
     */
    public function testSetPartExpression() : void
    {
        $schedule = new Schedule();
        $schedule->setPart(CronExpression::MINUTE, '0');
        $schedule->setPart(CronExpression::HOUR, '8-12');
        $schedule->setPart(CronExpression::DAY, '2,7,12');
        $schedule->setPart(CronExpression::MONTH, 'oct');
        $schedule->setPart(CronExpression::WEEKDAY, 'sat,sun');

        $this->assertEquals(
            "0 8-12 2,7,12 oct sat,sun",
            $schedule->getExpression()
        );
    }

    /**
     * @return void
     */
    public function testInvalidExpressionFullMonth() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $schedule = new Schedule();
        $schedule->setPart(CronExpression::MONTH, 'october');
    }

    /**
     * @return void
     */
    public function testInvalidExpressionUnknownValue() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $schedule = new Schedule();
        $schedule->setPart(CronExpression::MONTH, 'movember');
    }

    /**
     * @return void
     */
    public function testInvalidExpressionNegative() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $schedule = new Schedule();
        $schedule->setPart(CronExpression::MINUTE, '-5');
    }

}
