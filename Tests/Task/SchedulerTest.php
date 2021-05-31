<?php

namespace Prokl\TaskSchedulerBundle\Tests\Task;

use PHPUnit\Framework\TestCase;
use Prokl\TaskSchedulerBundle\Event\EventDispatcher;
use Prokl\TaskSchedulerBundle\Task\Scheduler;
use Prokl\TaskSchedulerBundle\Tests\EventSubscriberMock;

/**
 * Class SchedulerTest
 * @package Prokl\TaskSchedulerBundle\Tests\Task
 */
class SchedulerTest extends TestCase
{
    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        Task::$runCount = 0;
        ScheduledTask::$runCount = 0;
        EventSubscriberMock::$stack = [];
    }

    public function testRunningTask()
    {
        $scheduler = new Scheduler();
        $scheduler->addTask(new Task());
        $scheduler->addTask(new ScheduledTask());
        $scheduler->run();

        $this->assertEquals(1, Task::$runCount);
        $this->assertEquals(0, ScheduledTask::$runCount);
    }

    public function testRunningTaskWithDate()
    {
        $scheduler = new Scheduler();
        $scheduler->addTask(new Task());
        $scheduler->addTask(new ScheduledTask());
        $scheduler->run("2015-06-21 03:50:00");

        $this->assertEquals(1, Task::$runCount);
        $this->assertEquals(1, ScheduledTask::$runCount);
    }

    public function testCallingDispatcher()
    {
        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber(new EventSubscriberMock());

        $task = new Task();
        $scheduler = new Scheduler($eventDispatcher);
        $scheduler->addTask($task);
        $scheduler->run();

        $this->assertEquals([], EventSubscriberMock::$stack["onStart"]);
        $this->assertEquals([$task], EventSubscriberMock::$stack["beforeTaskRuns"]);
        $this->assertEquals([$task], EventSubscriberMock::$stack["afterTaskRuns"]);
        $this->assertArrayNotHasKey("onSkip", EventSubscriberMock::$stack);
        $this->assertEquals([], EventSubscriberMock::$stack["onEnd"]);
    }

    public function testCallingDispatcherOnSkip()
    {
        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber(new EventSubscriberMock());

        $task = new Task();
        $task->enable = false;

        $scheduler = new Scheduler($eventDispatcher);
        $scheduler->addTask($task);
        $scheduler->run();

        $this->assertEquals([], EventSubscriberMock::$stack["onStart"]);
        $this->assertArrayNotHasKey("beforeTaskRuns", EventSubscriberMock::$stack);
        $this->assertArrayNotHasKey("afterTaskRuns", EventSubscriberMock::$stack);
        $this->assertEquals([$task], EventSubscriberMock::$stack["onSkip"]);
        $this->assertEquals([], EventSubscriberMock::$stack["onEnd"]);
    }
}
