<?php

namespace Prokl\TaskSchedulerBundle\Tests;

use Prokl\TaskSchedulerBundle\Task\TaskInterface;

/**
 * Class TaskMock
 * @package Prokl\TaskSchedulerBundle\Tests
 */
class TaskMock implements TaskInterface
{
    static $runCount = 0;
    public $localCount = 0;

    /**
     * @inheritDoc
     */
    public function isDue($currentTime): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getNextRunDates(int $counter): array
    {
        return ['nextRunDate', 'anotherRunDate'];
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        self::$runCount++;
        $this->localCount++;
    }
}
