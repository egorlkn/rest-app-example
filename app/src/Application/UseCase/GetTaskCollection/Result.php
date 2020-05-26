<?php declare(strict_types=1);

namespace App\Application\UseCase\GetTaskCollection;

use App\Application\Domain\TaskCollection;

/**
 * Class Result
 * @package App\Application\UseCase\GetTaskCollection
 */
class Result
{
    private TaskCollection $taskCollection;

    /**
     * Result constructor.
     * @param TaskCollection $taskCollection
     */
    public function __construct(TaskCollection $taskCollection)
    {
        $this->taskCollection = $taskCollection;
    }

    /**
     * @return TaskCollection
     */
    public function getTaskCollection(): TaskCollection
    {
        return $this->taskCollection;
    }
}
