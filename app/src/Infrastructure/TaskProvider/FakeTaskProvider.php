<?php declare(strict_types=1);

namespace App\Infrastructure\TaskProvider;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskProvider\TaskProviderResult;
use App\Application\Domain\Task;
use App\Application\Domain\User;
use Exception;
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
     * @return TaskProviderResult
     * @throws Exception
     */
    public function getTask(UuidInterface $taskId, User $user): TaskProviderResult
    {
        if ($taskId->toString() !== '94164a7f-ce76-45f4-bb6a-a27932836ce9') {
            return TaskProviderResult::createFailedResult();
        }

        $task = new Task($taskId, 'Task one', $user->getId());

        return TaskProviderResult::createSuccessfulResult($task);
    }
}
