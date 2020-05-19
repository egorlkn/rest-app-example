<?php declare(strict_types=1);

namespace App\Application\UseCase\AddNewTask;

use App\Application\Domain\Task;

/**
 * Class AddNewTaskResult
 * @package App\Application\UseCase\AddNewTask
 */
class AddNewTaskResult
{
    /**
     * @var Task
     */
    private Task $task;

    /**
     * AddNewTaskResult constructor.
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
