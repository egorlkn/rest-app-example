<?php declare(strict_types=1);

namespace App\Application\UseCase\GetTaskCollection;

use App\Application\UseCase\GetTaskCollection\TaskProvider\TaskCollectionProvider;
use App\Application\UseCase\GetTaskCollection\UserProvider\CurrentUserProvider;

/**
 * Class Interactor
 * @package App\Application\UseCase\GetTaskCollection
 */
class Interactor implements GetTaskCollection
{
    /**
     * @var CurrentUserProvider
     */
    private CurrentUserProvider $currentUserProvider;

    /**
     * @var TaskCollectionProvider
     */
    private TaskCollectionProvider $taskCollectionProvider;

    /**
     * Interactor constructor.
     * @param CurrentUserProvider $currentUserProvider
     * @param TaskCollectionProvider $taskCollectionProvider
     */
    public function __construct(
        CurrentUserProvider $currentUserProvider,
        TaskCollectionProvider $taskCollectionProvider
    ) {
        $this->currentUserProvider = $currentUserProvider;
        $this->taskCollectionProvider = $taskCollectionProvider;
    }

    /**
     * @return GetTaskCollectionResult
     */
    public function getCollection(): GetTaskCollectionResult
    {
        $currentUserProviderResult = $this->currentUserProvider->getCurrentUser();

        $taskCollectionProviderResult = $this->taskCollectionProvider->getCollectionByUser(
            $currentUserProviderResult->getUser()
        );

        return new GetTaskCollectionResult($taskCollectionProviderResult);
    }
}
