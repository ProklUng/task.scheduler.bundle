<?php

namespace Prokl\TaskSchedulerBundle\Tests\Task;

use Prokl\TaskSchedulerBundle\Task\TaskInterface;

/**
 * Class Task
 * @package Prokl\TaskSchedulerBundle\Tests\Task
 */
class Task implements TaskInterface
{
    public static $runCount = 0;
    public $enable = true;

    /**
     * @inheritDoc
     */
    public function isDue($currentTime): bool
    {
        return $this->enable;
    }

    /**
     * @inheritDoc
     */
    public function getNextRunDates(int $counter): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        static::$runCount++;
    }
}