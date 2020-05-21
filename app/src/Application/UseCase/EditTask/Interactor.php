<?php declare(strict_types=1);

namespace App\Application\UseCase\EditTask;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Domain\Task;

/**
 * Class Interactor
 * @package App\Application\UseCase\EditTask
 */
class Interactor implements EditTask
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
     * @param InputData $inputData
     * @return Result
     */
    public function editTask(InputData $inputData): Result
    {
        $getUserResult = $this->currentUserProvider->getCurrentUser();
        $user = $getUserResult->getUser();

        $getTaskResult = $this->taskProvider->getTask($inputData->getTaskUuid(), $user);

        if (!$getTaskResult->isSuccessful()) {
            return Result::createFailedResult();
        }

        $oldTask = $getTaskResult->getTask();

        $editedTask = new Task(
            $oldTask->getUuid(),
            $inputData->getTaskName(),
            $oldTask->getUserUuid(),
            $inputData->isCompletedTask(),
            $oldTask->isDeleted()
        );

        $saveTaskResult =$this->taskSaver->saveTask($editedTask);
        $savedTask = $saveTaskResult->getTask();

        return Result::createSuccessfulResult($savedTask);
    }
}
