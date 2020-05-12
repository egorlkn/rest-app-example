<?php declare(strict_types=1);

namespace App\Application\UseCase\GetTaskCollection;

use App\Application\Domain\TaskCollection;

/**
 * Class GetTaskCollectionResult
 * @package App\Application\UseCase\GetTaskCollection
 */
class GetTaskCollectionResult
{
    private TaskCollection $taskCollection;

    /**
     * GetTaskCollectionResult constructor.
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
