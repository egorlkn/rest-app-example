<?php declare(strict_types=1);

namespace App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider;

use App\Core\Domain\User;

/**
 * Interface TaskCollectionProvider
 * @package App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider
 */
interface TaskCollectionProvider
{
    /**
     * @param User $user
     * @return TaskCollectionProviderResult
     */
    public function getCollectionByUser(User $user): TaskCollectionProviderResult;
}
