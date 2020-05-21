<?php declare(strict_types=1);

namespace App\Application\UseCase\AddNewTask;

use App\Application\Domain\Task;

/**
 * Class Result
 * @package App\Application\UseCase\AddNewTask
 */
class Result
{
    /**
     * @var Task
     */
    private Task $task;

    /**
     * Result constructor.
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
