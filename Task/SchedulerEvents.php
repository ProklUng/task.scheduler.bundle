<?php

namespace Prokl\TaskSchedulerBundle\Task;

/**
 * Class SchedulerEvents
 * @package Prokl\TaskSchedulerBundle\Task
 */
class SchedulerEvents
{
    public const ON_START = "onStart"; // called when the scheduler starts to loops through tasks
    public const BEFORE_TASK_RUNS = "beforeTaskRuns"; // called before a task gets executed
    public const AFTER_TASK_RUNS = "afterTaskRuns"; // called after a task gets executed
    public const ON_SKIP = "onSkip"; // called when the task is skipped
    public const ON_END = "onEnd"; // called after the scheduler runs all the tasks
}