<?php

namespace Prokl\TaskSchedulerBundle\Task;

/**
 * Class AbstractScheduledTask
 * @package Prokl\TaskSchedulerBundle\Task
 */
abstract class AbstractScheduledTask implements TaskInterface
{
    /**
     * @var Schedule $schedule
     */
    private $schedule;

    /**
     * AbstractScheduledTask constructor.
     */
    public function __construct()
    {
        $this->schedule = new Schedule();
        $this->initialize($this->schedule);
    }

    /**
     * @inheritDoc
     */
    public function isDue($currentTime): bool
    {
        return $this->schedule->isDue($currentTime);
    }

    /**
     * @inheritDoc
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * @inheritDoc
     */
    public function getNextRunDates(int $counter): array
    {
        $result = [];

        if ($counter < 1) {
            return $result;
        }

        for ($i = 0; $i < $counter; $i++) {
            $result[] = $this->schedule->getCron()->getNextRunDate('now', $i)->format(DATE_ATOM);
        }

        return $result;
    }

    /**
     * @param Schedule $schedule
     *
     * @return mixed
     */
    abstract protected function initialize(Schedule $schedule);
}
