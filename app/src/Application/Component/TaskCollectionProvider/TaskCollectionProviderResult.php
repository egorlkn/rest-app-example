<?php declare(strict_types=1);

namespace App\Application\Component\TaskCollectionProvider;

use App\Application\Domain\TaskCollection;

/**
 * Class TaskCollectionProviderResult
 * @package App\Application\Component\TaskCollectionProvider
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
