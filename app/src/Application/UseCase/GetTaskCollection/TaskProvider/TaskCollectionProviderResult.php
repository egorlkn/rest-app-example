<?php declare(strict_types=1);

namespace App\Application\UseCase\GetTaskCollection\TaskProvider;

use App\Application\Domain\TaskCollection;

/**
 * Class TaskCollectionProviderResult
 * @package App\Application\UseCase\GetTaskCollection\TaskProvider
 */
class TaskCollectionProviderResult
{
    /**
     * @var TaskCollection
     */
    private TaskCollection $taskCollection;

    /**
     * TaskCollectionProviderResult constructor.
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
