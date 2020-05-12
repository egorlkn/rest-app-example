<?php declare(strict_types=1);

namespace App\Application\UseCase\UpdateTask;

use Ramsey\Uuid\UuidInterface;

/**
 * Interface UpdateTask
 * @package App\Application\UseCase\UpdateTask
 */
interface UpdateTask
{
    /**
     * @param UuidInterface $taskId
     * @param string $newTaskName
     * @return UpdateTaskResult
     */
    public function updateTask(UuidInterface $taskId, string $newTaskName): UpdateTaskResult;
}
