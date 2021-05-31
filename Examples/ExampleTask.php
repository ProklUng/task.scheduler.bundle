<?php

namespace Prokl\TaskSchedulerBundle\Examples;

use Prokl\TaskSchedulerBundle\Task\AbstractScheduledTask;
use Prokl\TaskSchedulerBundle\Task\Schedule;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class ExampleTask
 * @package Prokl\TaskSchedulerBundle\Examples
 *
 * @since 10.12.2020
 */
class ExampleTask extends AbstractScheduledTask
{
    use ContainerAwareTrait;

    protected function initialize(Schedule $schedule) {
        $schedule
            ->everyMinutes(60); // Perform the task every 60 minutes
    }

    public function run() {
        $path = $this->container->getParameter('kernel.project_dir');

        file_put_contents(
            $path . '/test.log',
            'Test'
        );
    }
}