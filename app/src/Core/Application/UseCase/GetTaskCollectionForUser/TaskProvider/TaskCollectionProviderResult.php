<?php declare(strict_types=1);

namespace App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider;

use App\Core\Domain\TaskCollection;

/**
 * Class TaskCollectionProviderResult
 * @package App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider
 */
class TaskCollectionProviderResult
{
    /**
     * @var TaskCollection
     */
    private $taskCollection;

    /**
     * InteractorResult constructor.
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
