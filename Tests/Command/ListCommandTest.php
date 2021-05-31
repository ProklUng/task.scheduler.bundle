<?php

namespace Prokl\TaskSchedulerBundle\Tests\Command;

use Exception;
use Prokl\TaskSchedulerBundle\Command\ListCommand;
use Prokl\TaskSchedulerBundle\Task\Scheduler;
use Prokl\TaskSchedulerBundle\Tests\DependencyInjection\ContainerAwareTest;
use Prokl\TaskSchedulerBundle\Tests\TaskMock;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ListCommandTest
 * @package Prokl\TaskSchedulerBundle\Tests\Command
 */
class ListCommandTest extends ContainerAwareTest
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
     * @throws Exception
     */
    public function testListCommand() : void
    {
        $container = $this->loadContainer();
        /** @var Scheduler $scheduler */
        $scheduler = $container->get('ts.scheduler');
        $scheduler->addTask(new TaskMock());

        $application = new Application();
        $application->add(new ListCommand($scheduler));

        $command = $application->find('ts:list');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringNotContainsString('run dates', $output);
        $this->assertStringContainsString('| 1  | Prokl\TaskSchedulerBundle\Tests\TaskMock |', $output);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testListCommandWithOption() : void
    {
        $container = $this->loadContainer();
        $scheduler = $container->get('ts.scheduler');
        $scheduler->addTask(new TaskMock());

        $application = new Application();
        /** @var Scheduler $scheduler */
        $application->add(new ListCommand($scheduler));

        $command = $application->find('ts:list');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            '--show-run-dates' => 42,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('42 run dates', $output);
        $this->assertStringContainsString(
            '| 1  | Prokl\TaskSchedulerBundle\Tests\TaskMock | nextRunDate, anotherRunDate',
            $output
        );
    }
}
