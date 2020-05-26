<?php declare(strict_types=1);

namespace App\Application\UseCase\GetTaskCollection;

use App\Application\Component\TaskCollectionProvider\TaskCollectionProvider;
use App\Application\Component\UserProvider\CurrentUserProvider;

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
     * @return Result
     */
    public function getCollection(): Result
    {
        $currentUserProviderResult = $this->currentUserProvider->getCurrentUser();

        $taskCollectionProviderResult = $this->taskCollectionProvider->getCollection(
            $currentUserProviderResult->getUser()
        );
        $taskCollection = $taskCollectionProviderResult->getTaskCollection();

        return new Result($taskCollection);
    }
}
