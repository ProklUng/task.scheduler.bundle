<?php

namespace Prokl\TaskSchedulerBundle\Tests\DependencyInjection\Compiler;

use Exception;
use Prokl\TaskSchedulerBundle\DependencyInjection\Compiler\TaskPass;
use Prokl\TaskSchedulerBundle\Task\TaskInterface;
use Prokl\TaskSchedulerBundle\Tests\DependencyInjection\ContainerAwareTest;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class Task
 * @package Prokl\TaskSchedulerBundle\Tests\DependencyInjection\Compiler
 */
class Task implements TaskInterface
{
    static $runCount = 0;

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
        return [];
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        self::$runCount++;
    }
}

/**
 * Class TaskPassTest
 * @package Prokl\TaskSchedulerBundle\Tests\DependencyInjection\Compiler
 */
class TaskPassTest extends ContainerAwareTest
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        Task::$runCount = 0;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testLoadingPass()
    {
        $container = $this->loadContainer();

        $def = new Definition(Task::class);
        $def->addTag("ts.task");
        $container->setDefinition("mock.task", $def);

        $pass = new TaskPass();
        $pass->process($container);
        $container->compile();

        $scheduler = $container->get("ts.scheduler");
        $scheduler->run();

        $this->assertEquals(1, Task::$runCount);
    }
}
