<?php

namespace Prokl\TaskSchedulerBundle\Task;

use Prokl\TaskSchedulerBundle\Event\EventDispatcher;

/**
 * Class Scheduler
 * @package Prokl\TaskSchedulerBundle\Task
 */
class Scheduler
{
    /**
     * @var EventDispatcher $dispatcher
     */
    private $dispatcher;

    /**
     * Scheduler constructor.
     *
     * @param EventDispatcher|null $dispatcher
     */
    public function __construct(EventDispatcher $dispatcher = null)
    {
        if ($dispatcher === null) {
            $dispatcher = new EventDispatcher();
        }

        $this->dispatcher = $dispatcher;
    }

    /**
     * @var TaskInterface[]
     */
    private $tasks = [];

    /**
     * Adds the task to the task stack.
     *
     * @param TaskInterface $task Task.
     *
     * @return void
     */
    public function addTask(TaskInterface $task) : void
    {
        $this->tasks[] = $task;
    }

    /**
     * Run due tasks.
     *
     * @param string $currentTime
     *
     * @return void
     */
    public function run($currentTime = 'now') : void
    {
        $this->dispatcher->dispatch(SchedulerEvents::ON_START);
        foreach ($this->tasks as $task) {
            if ($task->isDue($currentTime)) {
                $this->runTask($task);
            } else {
                $this->dispatcher->dispatch(SchedulerEvents::ON_SKIP, [$task]);
            }
        }

        $this->dispatcher->dispatch(SchedulerEvents::ON_END);
    }

    /**
     * Run the task.
     *
     * @param TaskInterface $task
     *
     * @return void
     */
    public function runTask(TaskInterface $task) : void
    {
        $this->dispatcher->dispatch(SchedulerEvents::BEFORE_TASK_RUNS, [$task]);
        $task->run();
        $this->dispatcher->dispatch(SchedulerEvents::AFTER_TASK_RUNS, [$task]);
    }

    /**
     * @return TaskInterface[]
     */
    public function getTasks() : array
    {
        return $this->tasks;
    }
}
