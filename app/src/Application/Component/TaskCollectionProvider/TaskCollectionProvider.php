<?php declare(strict_types=1);

namespace App\Application\Component\TaskCollectionProvider;

use App\Application\Domain\User;

/**
 * Interface TaskCollectionProvider
 * @package App\Application\Component\TaskCollectionProvider
 */
interface TaskCollectionProvider
{
    /**
     * @param User $user
     * @param bool $includeDeleted
     * @return TaskCollectionProviderResult
     */
    public function getCollection(User $user, bool $includeDeleted = false): TaskCollectionProviderResult;
}
