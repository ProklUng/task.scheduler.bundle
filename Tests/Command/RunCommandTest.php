<?php

namespace Prokl\TaskSchedulerBundle\Tests\Command;

use Prokl\TaskSchedulerBundle\Command\RunCommand;
use Prokl\TaskSchedulerBundle\Task\Scheduler;
use Prokl\TaskSchedulerBundle\Tests\DependencyInjection\ContainerAwareTest;
use Prokl\TaskSchedulerBundle\Tests\TaskMock;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class RunCommandTest
 * @package Prokl\TaskSchedulerBundle\Tests\Command
 */
class RunCommandTest extends ContainerAwareTest
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        TaskMock::$runCount = 0;
    }

    /**
     * @return void
     */
    public function testRunCommand() : void
    {
        $container = $this->loadContainer();
        /** @var Scheduler $scheduler */
        $scheduler = $container->get('ts.scheduler');
        $scheduler->addTask(new TaskMock());

        $application = new Application();
        $application->add(new RunCommand($scheduler));
        $command = $application->find('ts:run');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
        ]);

        $this->assertEquals(1, TaskMock::$runCount);
    }

    /**
     * @return void
     */
    public function testRunCommandWithId() : void
    {
        $container = $this->loadContainer();
        /** @var Scheduler $scheduler */
        $scheduler = $container->get('ts.scheduler');

        $t1 = new TaskMock();
        $t2 = new TaskMock();

        $scheduler->addTask($t1);
        $scheduler->addTask($t2);

        $application = new Application();
        $application->add(new RunCommand($scheduler));
        $command = $application->find('ts:run');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'id' => 1,
        ]);

        $this->assertEquals(1, TaskMock::$runCount);
        $this->assertEquals(1, $t1->localCount);
        $this->assertEquals(0, $t2->localCount);
    }
}
