<?php declare(strict_types=1);

namespace App\Core\Application\UseCase\GetTaskCollectionForUser;

use App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider\TaskCollectionProviderResult;
use App\Core\Domain\TaskCollection;

/**
 * Class GetTaskCollectionForUserResult
 * @package App\Core\Application\UseCase\GetTaskCollectionForUser
 */
class GetTaskCollectionForUserResult
{
    /**
     * @var TaskCollectionProviderResult
     */
    private $taskCollectionProviderResult;

    /**
     * GetTaskCollectionForUserResult constructor.
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
