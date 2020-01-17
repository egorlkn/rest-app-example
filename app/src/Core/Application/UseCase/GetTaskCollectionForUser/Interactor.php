<?php declare(strict_types=1);

namespace App\Core\Application\UseCase\GetTaskCollectionForUser;

use App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider\TaskCollectionProvider;
use App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider\CurrentUserProvider;

/**
 * Class Interactor
 * @package App\Core\Application\UseCase\GetTaskCollectionForUser
 */
class Interactor implements GetTaskCollectionForUser
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
     * @return GetTaskCollectionForUserResult
     */
    public function getCollection(): GetTaskCollectionForUserResult
    {
        $currentUserProviderResult = $this->currentUserProvider->getCurrentUser();

        $taskCollectionProviderResult = $this->taskCollectionProvider->getCollectionByUser(
            $currentUserProviderResult->getUser()
        );

        return new GetTaskCollectionForUserResult($taskCollectionProviderResult);
    }
}
