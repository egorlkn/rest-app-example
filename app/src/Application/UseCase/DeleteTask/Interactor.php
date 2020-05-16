<?php declare(strict_types=1);

namespace App\Application\UseCase\DeleteTask;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Domain\Task;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Interactor
 * @package App\Application\UseCase\DeleteTask
 */
class Interactor implements DeleteTask
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
     * @return DeleteTaskResult
     */
    public function deleteTask(UuidInterface $taskUuid): DeleteTaskResult
    {
        $getUserResult = $this->currentUserProvider->getCurrentUser();
        $user = $getUserResult->getUser();

        $getTaskResult = $this->taskProvider->getTask($taskUuid, $user);

        if (!$getTaskResult->isSuccessful()) {
            return DeleteTaskResult::createNotFoundResult();
        }

        $task = $getTaskResult->getTask();

        $deletedTask = new Task($task->getId(), $task->getName(), $task->getUserId(), true);

        $this->taskSaver->saveTask($deletedTask);

        return DeleteTaskResult::createSuccessfulResult();
    }
}
