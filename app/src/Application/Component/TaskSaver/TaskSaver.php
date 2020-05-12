<?php declare(strict_types=1);

namespace App\Application\Component\TaskSaver;

use App\Application\Domain\Task;

/**
 * Interface TaskSaver
 * @package App\Application\Component\TaskSaver
 */
interface TaskSaver
{
    /**
     * @param Task $task
     * @return TaskSaverResult
     */
    public function saveTask(Task $task): TaskSaverResult;
}
