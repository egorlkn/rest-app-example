<?php declare(strict_types=1);

namespace App\Application\UseCase\MarkTaskAsCompleted;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Domain\Task;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Interactor
 * @package App\Application\UseCase\MarkTaskAsCompleted
 */
class Interactor implements MarkTaskAsCompleted
{
    /**
     * @var CurrentUserProvider
     */
    private CurrentUserProvider $currentUserProvider;

    /**
     * @var TaskProvider
     */
    private TaskProvider $taskProvider;

    /**
     * @var TaskSaver
     */
    private TaskSaver $taskSaver;

    /**
     * Interactor constructor.
     * @param CurrentUserProvider $currentUserProvider
     * @param TaskProvider $taskProvider
     * @param TaskSaver $taskSaver
     */
    public function __construct(
        CurrentUserProvider $currentUserProvider,
        TaskProvider $taskProvider,
        TaskSaver $taskSaver
    ) {
        $this->currentUserProvider = $currentUserProvider;
        $this->taskProvider = $taskProvider;
        $this->taskSaver = $taskSaver;
    }

    /**
     * @param UuidInterface $taskUuid
     * @return MarkTaskAsCompletedResult
     */
    public function markTaskAsCompleted(UuidInterface $taskUuid): MarkTaskAsCompletedResult
    {
        $getUserResult = $this->currentUserProvider->getCurrentUser();
        $user = $getUserResult->getUser();

        $getOldTaskResult = $this->taskProvider->getTask($taskUuid, $user);

        if (!$getOldTaskResult->isSuccessful()) {
            return MarkTaskAsCompletedResult::createFailedResult();
        }

        $oldTask = $getOldTaskResult->getTask();

        $markedTask = new Task(
            $oldTask->getUuid(),
            $oldTask->getName(),
            $oldTask->getUserUuid(),
            true,
            $oldTask->isDeleted()
        );

        $saveTaskResult = $this->taskSaver->saveTask($markedTask);
        $savedTask = $saveTaskResult->getTask();

        return MarkTaskAsCompletedResult::createSuccessfulResult($savedTask);
    }
}
