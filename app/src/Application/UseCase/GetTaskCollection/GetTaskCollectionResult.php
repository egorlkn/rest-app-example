<?php declare(strict_types=1);

namespace App\Application\UseCase\GetTaskCollection;

use App\Application\Domain\TaskCollection;
use App\Application\UseCase\GetTaskCollection\TaskProvider\TaskCollectionProviderResult;

/**
 * Class GetTaskCollectionResult
 * @package App\Application\UseCase\GetTaskCollection
 */
class GetTaskCollectionResult
{
    /**
     * @var TaskCollectionProviderResult
     */
    private TaskCollectionProviderResult $taskCollectionProviderResult;

    /**
     * GetTaskCollectionResult constructor.
     * @param TaskCollectionProviderResult $taskCollectionProviderResult
     */
    public function __construct(TaskCollectionProviderResult $taskCollectionProviderResult)
    {
        $this->taskCollectionProviderResult = $taskCollectionProviderResult;
    }

    /**
     * @return TaskCollection
     */
    public function getTaskCollection(): TaskCollection
    {
        return $this->taskCollectionProviderResult->getTaskCollection();
    }
}
