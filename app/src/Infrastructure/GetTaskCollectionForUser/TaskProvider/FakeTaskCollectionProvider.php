<?php declare(strict_types=1);

namespace App\Infrastructure\GetTaskCollectionForUser\TaskProvider;

use App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider\TaskCollectionProvider;
use App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider\TaskCollectionProviderResult;
use App\Core\Domain\Task;
use App\Core\Domain\TaskCollection;
use App\Core\Domain\User;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid;

/**
 * Class FakeTaskCollectionProvider
 * @package App\Infrastructure\GetTaskCollectionForUser\TaskProvider
 */
class FakeTaskCollectionProvider implements TaskCollectionProvider
{
    /**
     * @param User $user
     * @return TaskCollectionProviderResult
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function getCollectionByUser(User $user): TaskCollectionProviderResult
    {
        $taskCollection = $this->createTaskCollection($user);

        return new TaskCollectionProviderResult($taskCollection);
    }

    /**
     * @param User $user
     * @return TaskCollection
     * @throws UnsatisfiedDependencyException
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    private function createTaskCollection(User $user): TaskCollection
    {
        $userId = $user->getId();

        return new TaskCollection(
            [
                new Task(Uuid::fromString('8e80aeaa-ae5b-4970-a54d-c5a29cc59a0e'), 'Task one', $userId),
                new Task(Uuid::fromString('e014b55e-8769-4a73-b7ea-81541abd7713'), 'Task two', $userId),
                new Task(Uuid::fromString('2af76c6a-a613-4f74-827d-f8e735f2e1ce'), 'Task three', $userId),
            ]
        );
    }
}
