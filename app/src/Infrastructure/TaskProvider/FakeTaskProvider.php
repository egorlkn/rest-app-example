<?php declare(strict_types=1);

namespace App\Infrastructure\TaskProvider;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskProvider\TaskProviderResult;
use App\Application\Domain\Task;
use App\Application\Domain\User;
use Ramsey\Uuid\UuidInterface;

/**
 * Class FakeTaskProvider
 * @package App\Infrastructure\TaskProvider
 */
class FakeTaskProvider implements TaskProvider
{
    /**
     * @param UuidInterface $taskId
     * @param User $user
     * @param bool $includeDeleted
     * @return TaskProviderResult
     */
    public function getTask(UuidInterface $taskId, User $user, bool $includeDeleted = false): TaskProviderResult
    {
        if ($taskId->toString() === '94164a7f-ce76-45f4-bb6a-a27932836ce9') {
            return TaskProviderResult::createSuccessfulResult(new Task($taskId, 'Task one', $user->getId()));
        }

        if ($includeDeleted && $taskId->toString() === 'f5fa3e5f-cf2e-42a9-a2db-370dcb5384c6') {
            return TaskProviderResult::createSuccessfulResult(new Task($taskId, 'Task two', $user->getId(), true));
        }

        return TaskProviderResult::createFailedResult();
    }
}
