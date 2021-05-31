<?php

namespace Prokl\TaskSchedulerBundle\Tests\Task;

use Prokl\TaskSchedulerBundle\Task\AbstractScheduledTask;
use Prokl\TaskSchedulerBundle\Task\Schedule;

/**
 * Class ScheduledTask
 * @package Prokl\TaskSchedulerBundle\Tests\Task
 */
class ScheduledTask extends AbstractScheduledTask
{
    public static $runCount = 0;

    /**
     * @inheritDoc
     */
    protected function initialize(Schedule $schedule)
    {
        $schedule
            ->daily()
            ->hours(3)
            ->minutes(50);
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        static::$runCount++;
    }
}