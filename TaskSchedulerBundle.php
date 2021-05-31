<?php

namespace Prokl\TaskSchedulerBundle;

use Prokl\TaskSchedulerBundle\DependencyInjection\Compiler\EventDispatcherPass;
use Prokl\TaskSchedulerBundle\DependencyInjection\Compiler\TaskPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class TaskSchedulerBundle
 * @package Prokl\TaskSchedulerBundle
 */
final class TaskSchedulerBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TaskPass());
        $container->addCompilerPass(new EventDispatcherPass());
    }
}
