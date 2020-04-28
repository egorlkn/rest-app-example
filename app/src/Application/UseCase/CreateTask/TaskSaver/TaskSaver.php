<?php declare(strict_types=1);

namespace App\Application\UseCase\CreateTask\TaskSaver;

use App\Application\Domain\Task;

/**
 * Interface TaskSaver
 * @package App\Application\UseCase\TaskSaver
 */
interface TaskSaver
{
    /**
     * @param Task $task
     * @return TaskSaverResult
     */
    public function saveTask(Task $task): TaskSaverResult;
}
