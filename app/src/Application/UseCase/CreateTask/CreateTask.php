<?php declare(strict_types=1);

namespace App\Application\UseCase\CreateTask;

/**
 * Interface CreateTask
 * @package App\Application\UseCase\CreateTask
 */
interface CreateTask
{
    /**
     * @param string $taskName
     * @return CreateTaskResult
     */
    public function createTask(string $taskName): CreateTaskResult;
}
