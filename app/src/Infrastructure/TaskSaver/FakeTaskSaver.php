<?php declare(strict_types=1);

namespace App\Infrastructure\TaskSaver;

use App\Application\Domain\Task;
use App\Application\UseCase\CreateTask\TaskSaver\TaskSaver;
use App\Application\UseCase\CreateTask\TaskSaver\TaskSaverResult;

/**
 * Class FakeTaskSaver
 * @package App\Infrastructure\TaskSaver
 */
class FakeTaskSaver implements TaskSaver
{
    /**
     * @param Task $task
     * @return TaskSaverResult
     */
    public function saveTask(Task $task): TaskSaverResult
    {
        return new TaskSaverResult($task);
    }
}
