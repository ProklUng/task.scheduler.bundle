<?php

namespace Prokl\TaskSchedulerBundle\Tests\Event;

use PHPUnit\Framework\TestCase;
use Prokl\TaskSchedulerBundle\Event\EventDispatcher;

/**
 * Class EventDispatcherTest
 * @package Prokl\TaskSchedulerBundle\Tests\Event
 */
class EventDispatcherTest extends TestCase
{
    /**
     * @inheritDoc
     */
    public function testEventDispatcher() : void
    {
        $dispatcher = new EventDispatcher();
        $subscriber = new DummySubscriber();
        $dispatcher->addSubscriber($subscriber);

        $dispatcher->dispatch("foo", [1, 2, 3]);
        $this->assertEquals([1, 2, 3], $subscriber->args);
    }
}