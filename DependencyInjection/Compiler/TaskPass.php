<?php

namespace Prokl\TaskSchedulerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class TaskPass
 * @package Prokl\TaskSchedulerBundle\DependencyInjection\Compiler
 *
 * Adds services tagged with "ts.task" to the scheduler
 */
class TaskPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('ts.scheduler');
        $tasks = $container->findTaggedServiceIds('ts.task');

        foreach ($tasks as $id => $tags) {
            $definition->addMethodCall('addTask', [new Reference($id)]);
        }
    }
}
