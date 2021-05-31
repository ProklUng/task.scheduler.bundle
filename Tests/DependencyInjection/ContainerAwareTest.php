<?php

namespace Prokl\TaskSchedulerBundle\Tests\DependencyInjection;

use Exception;
use PHPUnit\Framework\TestCase;
use Prokl\TaskSchedulerBundle\DependencyInjection\RewieerTaskSchedulerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ContainerAwareTest
 * @package Prokl\TaskSchedulerBundle\Tests\DependencyInjection
 */
abstract class ContainerAwareTest extends TestCase
{
    /**
     * @param array $config
     *
     * @return ContainerBuilder
     * @throws Exception
     */
    public function loadContainer(array $config = [])
    {
        $container = new ContainerBuilder();
        $extension = new RewieerTaskSchedulerExtension();
        $extension->load($config, $container);

        return $container;
    }
}