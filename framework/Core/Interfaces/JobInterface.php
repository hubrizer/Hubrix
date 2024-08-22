<?php

namespace Hubrix\Core\Interfaces;

/**
 * Interface JobInterface
 *
 * This interface defines the contract for job classes within the Hubrix framework.
 * Any class that represents a job/task should implement this interface.
 *
 * @package Hubrix\Core\Interfaces
 */
interface JobInterface
{
    /**
     * Handle the execution of the job.
     *
     * This method contains the logic that should be executed when the job is processed.
     *
     * @return void
     */
    public function handle(): void;

    /**
     * Determine the maximum number of times the job may be attempted.
     *
     * @return int
     */
    public function maxAttempts(): int;

    /**
     * Specify the delay (in seconds) before the job should be retried after a failure.
     *
     * @return int
     */
    public function retryDelay(): int;

    /**
     * Serialize the job's data for storage.
     *
     * @return array
     */
    public function serialize(): array;

    /**
     * Unserialize the job's data from storage.
     *
     * @param array $data
     * @return void
     */
    public function unserialize(array $data): void;
}
