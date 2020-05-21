<?php declare(strict_types=1);

namespace App\Application\UseCase\AddNewTask;

use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Domain\Task;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * Class Interactor
 * @package App\Application\UseCase\AddNewTask
 */
class Interactor implements AddNewTask
{
    /**
     * @var CurrentUserProvider
     */
    private CurrentUserProvider $currentUserProvider;

    /**
     * @var TaskSaver
     */
    private TaskSaver $taskSaver;

    /**
     * Interactor constructor.
     * @param CurrentUserProvider $currentUserProvider
     * @param TaskSaver $taskSaver
     */
    public function __construct(CurrentUserProvider $currentUserProvider, TaskSaver $taskSaver)
    {
        $this->currentUserProvider = $currentUserProvider;
        $this->taskSaver = $taskSaver;
    }

    /**
     * @param InputData $inputData
     * @return Result
     * @throws Exception
     */
    public function addNewTask(InputData $inputData): Result
    {
        $getUserResult = $this->currentUserProvider->getCurrentUser();
        $user = $getUserResult->getUser();

        $task = new Task(
            Uuid::uuid4(),
            $inputData->getTaskName(),
            $user->getUuid(),
            $inputData->isCompletedTask()
        );

        $saveTaskResult = $this->taskSaver->saveTask($task);
        $savedTask = $saveTaskResult->getTask();

        return new Result($savedTask);
    }
}
