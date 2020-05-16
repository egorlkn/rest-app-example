<?php declare(strict_types=1);

namespace App\Application\UseCase\MarkTaskAsDeleted;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Domain\Task;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Interactor
 * @package App\Application\UseCase\MarkTaskAsDeleted
 */
class Interactor implements MarkTaskAsDeleted
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
     * @return MarkTaskAsDeletedResult
     */
    public function markTaskAsDeleted(UuidInterface $taskUuid): MarkTaskAsDeletedResult
    {
        $getUserResult = $this->currentUserProvider->getCurrentUser();
        $user = $getUserResult->getUser();

        $getTaskResult = $this->taskProvider->getTask($taskUuid, $user);

        if (!$getTaskResult->isSuccessful()) {
            return MarkTaskAsDeletedResult::createFailedResult();
        }

        $oldTask = $getTaskResult->getTask();

        $markedTask = new Task(
            $oldTask->getUuid(),
            $oldTask->getName(),
            $oldTask->getUserUuid(),
            $oldTask->isCompleted(),
            true
        );

        $saveTaskResult =$this->taskSaver->saveTask($markedTask);
        $savedTask = $saveTaskResult->getTask();

        return MarkTaskAsDeletedResult::createSuccessfulResult($savedTask);
    }
}
