<?php

namespace Prokl\TaskSchedulerBundle\Tests;

use Prokl\TaskSchedulerBundle\Event\EventSubscriberInterface;
use Prokl\TaskSchedulerBundle\Task\SchedulerEvents;

/**
 * Class EventSubscriberMock
 * @package Prokl\TaskSchedulerBundle\Tests
 */
class EventSubscriberMock implements EventSubscriberInterface
{
    public static $stack = [];

    public function onStart()
    {
        self::$stack["onStart"] = func_get_args();
    }

    public function beforeTaskRuns()
    {
        self::$stack["beforeTaskRuns"] = func_get_args();
    }

    public function afterTaskRuns()
    {
        self::$stack["afterTaskRuns"] = func_get_args();
    }

    public function onEnd()
    {
        self::$stack["onEnd"] = func_get_args();
    }

    public function onSkip()
    {
        self::$stack["onSkip"] = func_get_args();
    }

    public static function getEvents(): array
    {
        return [
            SchedulerEvents::ON_START => "onStart",
            SchedulerEvents::BEFORE_TASK_RUNS => "beforeTaskRuns",
            SchedulerEvents::AFTER_TASK_RUNS => "afterTaskRuns",
            SchedulerEvents::ON_SKIP => "onSkip",
            SchedulerEvents::ON_END => "onEnd",
        ];
    }
}