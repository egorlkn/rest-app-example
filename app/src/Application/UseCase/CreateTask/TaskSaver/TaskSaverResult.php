<?php declare(strict_types=1);

namespace App\Application\UseCase\CreateTask\TaskSaver;

use App\Application\Domain\Task;

/**
 * Class TaskSaverResult
 * @package App\Application\UseCase\CreateTask\TaskSaver
 */
class TaskSaverResult
{
    /**
     * @var Task
     */
    private Task $task;

    /**
     * CreateTaskResult constructor.
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @return Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }
}
