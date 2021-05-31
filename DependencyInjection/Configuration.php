<?php

namespace Prokl\TaskSchedulerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Prokl\TaskSchedulerBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('task_scheduler');

        if (false === \method_exists($treeBuilder, 'getRootNode')) {
          // BC layer for symfony/config 4.1 and older
            $treeBuilder->root('task_scheduler');
        }

        return $treeBuilder;
    }
}
