<?php declare(strict_types=1);

namespace App\Application\UseCase\CreateTask;

use App\Application\Domain\Task;

/**
 * Class CreateTaskResult
 * @package App\Application\UseCase\CreateTask
 */
class CreateTaskResult
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
