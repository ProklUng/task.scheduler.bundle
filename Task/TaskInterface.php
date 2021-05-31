<?php

namespace Prokl\TaskSchedulerBundle\Task;

use Datetime;

/**
 * Interface TaskInterface
 * @package Prokl\TaskSchedulerBundle\Task
 */
interface TaskInterface {
  /**
   * Return true if the task is due to now
   *
   * @param Datetime|string $currentTime
   *
   * @return boolean
   */
  public function isDue($currentTime) : bool;

  /**
   * Get the next run dates for this job.
   *
   * @param integer $counter
   *
   * @return string[]
   */
  public function getNextRunDates(int $counter) : array;

  /**
   * Execute the task
   */
  public function run();
}
