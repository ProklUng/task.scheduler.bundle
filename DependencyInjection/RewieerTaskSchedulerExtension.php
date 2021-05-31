<?php

namespace Prokl\TaskSchedulerBundle\DependencyInjection;

use Exception;
use Prokl\TaskSchedulerBundle\Task\TaskInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class RewieerTaskSchedulerExtension
 * @package Prokl\TaskSchedulerBundle\DependencyInjection
 */
final class RewieerTaskSchedulerExtension extends Extension
{
    /**
     * @inheritDoc
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(TaskInterface::class)->addTag('ts.task');

        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (!$container->hasDefinition('logger')) {
            $container->removeDefinition('ts.scheduler_logger');
        }
    }
}
