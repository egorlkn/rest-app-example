<?php declare(strict_types=1);

namespace App\Application\Component\TaskProvider;

use App\Application\Domain\User;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface TaskProvider
 * @package App\Application\Component\TaskProvider
 */
interface TaskProvider
{
    /**
     * @param UuidInterface $taskId
     * @param User $user
     * @param bool $includeDeleted
     * @return TaskProviderResult
     */
    public function getTask(UuidInterface $taskId, User $user, bool $includeDeleted = false): TaskProviderResult;
}
