<?php

namespace Prokl\TaskSchedulerBundle\Services;

use Psr\Log\LoggerInterface;
use Prokl\TaskSchedulerBundle\Event\EventSubscriberInterface;
use Prokl\TaskSchedulerBundle\Task\SchedulerEvents;
use Prokl\TaskSchedulerBundle\Task\TaskInterface;

/**
 * Class SchedulerLogger
 * @package Prokl\TaskSchedulerBundle\Services
 * A default logger for the scheduler
 */
class SchedulerLogger implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    private $start;
    private $current;

    /**
     * SchedulerLogger constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return void
     */
    public function onStart() : void
    {
        $this->start = microtime(true);
        $this->logger->info(
            sprintf(
                '[%s] Starting...',
                (new \Datetime())->format('d/m/y H:i:s')
            )
        );
    }

    /**
     * @param TaskInterface $task Task.
     *
     * @return void
     */
    public function beforeTaskRuns(TaskInterface $task) : void
    {
        $this->current = microtime(true);
        $this->logger->info(sprintf(
            'Running %s',
            get_class($task)
        ));
    }

    /**
     * @param TaskInterface $task Task.
     *
     * @return void
     */
    public function afterTaskRuns(TaskInterface $task) : void
    {
        $time = microtime(true) - $this->current;
        $this->logger->info(sprintf(
            'Finished %s in %fs',
            get_class($task),
            $time
        ));
    }

    /**
     * @return void
     */
    public function onEnd() : void
    {
        $time = microtime(true) - $this->start;
        $this->logger->info(sprintf('Finished ! Took %fs', $time));
    }

    /**
     * @param TaskInterface $task Task.
     *
     * @return void
     */
    public function onSkip(TaskInterface $task) : void
    {
        $this->logger->info(sprintf(
            'Skipped %s',
            get_class($task)
        ));
    }

    /**
     * @inheritDoc
     */
    public static function getEvents(): array
    {
        return [
            SchedulerEvents::ON_START => 'onStart',
            SchedulerEvents::BEFORE_TASK_RUNS => 'beforeTaskRuns',
            SchedulerEvents::AFTER_TASK_RUNS => 'afterTaskRuns',
            SchedulerEvents::ON_SKIP => 'onSkip',
            SchedulerEvents::ON_END => 'onEnd',
        ];
    }
}
