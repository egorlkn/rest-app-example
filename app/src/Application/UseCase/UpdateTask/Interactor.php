<?php declare(strict_types=1);

namespace App\Application\UseCase\UpdateTask;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Domain\Task;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Interactor
 * @package App\Application\UseCase\UpdateTask
 */
class Interactor implements UpdateTask
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
     * @param UuidInterface $taskId
     * @param string $newTaskName
     * @return UpdateTaskResult
     */
    public function updateTask(UuidInterface $taskId, string $newTaskName): UpdateTaskResult
    {
        $getUserResult = $this->currentUserProvider->getCurrentUser();
        $user = $getUserResult->getUser();

        $getOldTaskResult = $this->taskProvider->getTask($taskId, $user);

        if (!$getOldTaskResult->isSuccessful()) {
            return UpdateTaskResult::createFailedResult();
        }

        $oldTask = $getOldTaskResult->getTask();

        $updatedTask = new Task($oldTask->getId(), $newTaskName, $oldTask->getUserId());

        $saveTaskResult = $this->taskSaver->saveTask($updatedTask);
        $savedTask = $saveTaskResult->getTask();

        return UpdateTaskResult::createSuccessfulResult($savedTask);
    }
}
