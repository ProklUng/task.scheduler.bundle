<?php

namespace Prokl\TaskSchedulerBundle\Tests\DependencyInjection\Compiler;

use Exception;
use Prokl\TaskSchedulerBundle\DependencyInjection\Compiler\EventDispatcherPass;
use Prokl\TaskSchedulerBundle\Tests\DependencyInjection\ContainerAwareTest;
use Prokl\TaskSchedulerBundle\Tests\EventSubscriberMock;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class EventDispatcherPassTest
 * @package Prokl\TaskSchedulerBundle\Tests\DependencyInjection\Compiler
 */
class EventDispatcherPassTest extends ContainerAwareTest
{
    /**
     * @return void
     * @throws Exception
     */
    public function testLoadingPass(): void
    {
        $container = $this->loadContainer();

        $def = new Definition(EventSubscriberMock::class);
        $def->addTag("ts.event_subscriber");
        $def->setPublic(true);
        $container->setDefinition("mock.event_subscriber", $def);

        $pass = new EventDispatcherPass();
        $pass->process($container);
        $container->compile();

        $dispatcher = $container->get("ts.event_dispatcher");
        $this->assertEquals([
            $container->get("mock.event_subscriber"),
        ], $dispatcher->getSubscribers());
    }
}
