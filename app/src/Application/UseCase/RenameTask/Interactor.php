<?php declare(strict_types=1);

namespace App\Application\UseCase\RenameTask;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Domain\Task;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Interactor
 * @package App\Application\UseCase\RenameTask
 */
class Interactor implements RenameTask
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
     * @param string $newTaskName
     * @return RenameTaskResult
     */
    public function renameTask(UuidInterface $taskUuid, string $newTaskName): RenameTaskResult
    {
        $getUserResult = $this->currentUserProvider->getCurrentUser();
        $user = $getUserResult->getUser();

        $getOldTaskResult = $this->taskProvider->getTask($taskUuid, $user);

        if (!$getOldTaskResult->isSuccessful()) {
            return RenameTaskResult::createFailedResult();
        }

        $oldTask = $getOldTaskResult->getTask();

        $renamedTask = new Task($oldTask->getUuid(), $newTaskName, $oldTask->getUserUuid(), $oldTask->isCompleted());

        $saveTaskResult = $this->taskSaver->saveTask($renamedTask);
        $savedTask = $saveTaskResult->getTask();

        return RenameTaskResult::createSuccessfulResult($savedTask);
    }
}
