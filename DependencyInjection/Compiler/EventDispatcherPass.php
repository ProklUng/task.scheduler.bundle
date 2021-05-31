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
class EventDispatcherPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('ts.event_dispatcher');
        $tasks = $container->findTaggedServiceIds('ts.event_subscriber');

        foreach ($tasks as $id => $tags) {
            $definition->addMethodCall('addSubscriber', [new Reference($id)]);
        }
    }
}
