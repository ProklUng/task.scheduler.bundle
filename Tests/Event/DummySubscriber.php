<?php

namespace Prokl\TaskSchedulerBundle\Tests\Event;

use Prokl\TaskSchedulerBundle\Event\EventSubscriberInterface;

/**
 * Class DummySubscriber
 * @package Prokl\TaskSchedulerBundle\Tests\Event
 */
class DummySubscriber implements EventSubscriberInterface
{
    public $args;

    public function callFoo()
    {
        $this->args = func_get_args();
    }

    public static function getEvents(): array
    {
        return [
            "foo" => "callFoo"
        ];
    }
}