<?php declare(strict_types=1);

namespace App\Application\UseCase\GetTaskCollection\TaskCollectionProvider;

use App\Application\Domain\User;

/**
 * Interface TaskCollectionProvider
 * @package App\Application\UseCase\GetTaskCollection\TaskCollectionProvider
 */
interface TaskCollectionProvider
{
    /**
     * @param User $user
     * @return TaskCollectionProviderResult
     */
    public function getCollection(User $user): TaskCollectionProviderResult;
}
