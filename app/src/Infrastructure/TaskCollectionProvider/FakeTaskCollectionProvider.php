<?php declare(strict_types=1);

namespace App\Infrastructure\TaskCollectionProvider;

use App\Application\Component\TaskCollectionProvider\TaskCollectionProvider;
use App\Application\Component\TaskCollectionProvider\TaskCollectionProviderResult;
use App\Application\Domain\Task;
use App\Application\Domain\TaskCollection;
use App\Application\Domain\User;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

/**
 * Class FakeTaskCollectionProvider
 * @package App\Infrastructure\TaskCollectionProvider
 */
class FakeTaskCollectionProvider implements TaskCollectionProvider
{
    /**
     * @param User $user
     * @param bool $includeDeleted
     * @return TaskCollectionProviderResult
     * @throws InvalidUuidStringException
     */
    public function getCollection(User $user, bool $includeDeleted = false): TaskCollectionProviderResult
    {
        $taskCollection = $this->createTaskCollection($user, $includeDeleted);

        return new TaskCollectionProviderResult($taskCollection);
    }

    /**
     * @param User $user
     * @param bool $includeDeleted
     * @return TaskCollection
     */
    private function createTaskCollection(User $user, bool $includeDeleted): TaskCollection
    {
        $userUuid = $user->getUuid();

        $collection = new TaskCollection(
            [
                new Task(Uuid::fromString('8e80aeaa-ae5b-4970-a54d-c5a29cc59a0e'), 'Task one', $userUuid, true),
                new Task(Uuid::fromString('e014b55e-8769-4a73-b7ea-81541abd7713'), 'Task two', $userUuid),
                new Task(Uuid::fromString('2af76c6a-a613-4f74-827d-f8e735f2e1ce'), 'Task three', $userUuid, true),
            ]
        );

        if (!$includeDeleted) {
            return $collection;
        }

        $collection->append(
            new Task(Uuid::fromString('8a5c1bf0-f911-4880-ab76-2a14e75066cc'), 'Task four', $userUuid, true, true)
        );
        $collection->append(
            new Task(Uuid::fromString('e908dba1-fb8e-4509-b1fc-8e6f96b48819'), 'Task five', $userUuid, false, true)
        );

        return $collection;
    }
}
