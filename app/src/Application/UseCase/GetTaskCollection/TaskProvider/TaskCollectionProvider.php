<?php declare(strict_types=1);

namespace App\Application\UseCase\GetTaskCollection\TaskProvider;

use App\Application\Domain\User;

/**
 * Interface TaskCollectionProvider
 * @package App\Application\UseCase\GetTaskCollection\TaskProvider
 */
interface TaskCollectionProvider
{
    /**
     * @param User $user
     * @return TaskCollectionProviderResult
     */
    public function getCollectionByUser(User $user): TaskCollectionProviderResult;
}
