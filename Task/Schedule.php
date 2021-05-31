<?php

namespace Prokl\TaskSchedulerBundle\Task;

use Cron\CronExpression;
use Cron\FieldFactory;
use DateTimeInterface;

/**
 * Class Schedule
 * @package Prokl\TaskSchedulerBundle\Task
 */
class Schedule
{
    /**
     * @var CronExpression $cron
     */
    private $cron;

    /**
     * Schedule constructor.
     *
     * @param string $expr the default cron.
     */
    public function __construct(string $expr = '* * * * *')
    {
        $this->cron = new CronExpression($expr, new FieldFactory());
    }

    /**
     * Sets the cron to work every day.
     *
     * @return $this
     */
    public function daily() : self
    {
        $this->cron->setPart(CronExpression::DAY, '*');

        return $this;
    }

    /**
     * Set the cron to work at this hour.
     *
     * @param integer $hour
     *
     * @return $this
     */
    public function hours(int $hour) : self
    {
        $this->cron->setPart(CronExpression::HOUR, (string)$hour);

        return $this;
    }

    /**
     * Set the cron to work at this minutes.
     *
     * @param integer $minutes
     *
     * @return $this
     */
    public function minutes(int $minutes) : self
    {
        $this->cron->setPart(CronExpression::MINUTE, (string)$minutes);

        return $this;
    }

    /**
     * Set the cron to work at every x minutes.
     *
     * @param integer $minutes
     *
     * @return $this
     */
    public function everyMinutes(int $minutes = 1) : self
    {
        return $this->everyX($minutes, CronExpression::MINUTE);
    }

    /**
     * Set the cron to work at every x hours.
     *
     * @param integer $hours Hours.
     *
     * @return $this
     */
    public function everyHours(int $hours = 1) : self
    {
        return $this->everyX($hours, CronExpression::HOUR);
    }

    /**
     * Generic function to update a cron part as an "everyX" pattern
     * such as "every 3 hours" or "every 10 minutes"
     *
     * @param integer $time
     * @param integer $part
     *
     * @return $this
     */
    public function everyX(int $time = 1, int $part = CronExpression::MINUTE) : self
    {
        if ($time === 0 || $time === 1) {
            $expr = '*';
        } else {
            $expr = '*/'.(string)$time;
        }

        $this->cron->setPart($part, $expr);

        return $this;
    }

    /**
     * @return CronExpression
     */
    public function getCron() : CronExpression
    {
        return $this->cron;
    }

    /**
     * @return string
     */
    public function getExpression() : string
    {
        return $this->cron->getExpression();
    }

    /**
     * Allows setting entire expression in string format like "0 * 2,7,12 * 7".
     * Exposes CronExpressions method directly.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setExpression(string $value) : self
    {
        $this->cron->setExpression($value);

        return $this;
    }

    /**
     * @param integer $position
     * @param string  $value
     *
     * @return $this
     */
    public function setPart(int $position, string $value) : self
    {
        $this->cron->setPart($position, $value);

        return $this;
    }

    /**
     * Return true if the schedule is due to now.
     *
     * @param DateTimeInterface|string $currentTime Time.
     *
     * @return boolean
     */
    public function isDue($currentTime = 'now')
    {
        return $this->cron->isDue($currentTime);
    }
}
