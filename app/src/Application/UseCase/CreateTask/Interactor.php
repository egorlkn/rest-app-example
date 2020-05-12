<?php declare(strict_types=1);

namespace App\Application\UseCase\CreateTask;

use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Domain\Task;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * Class Interactor
 * @package App\Application\UseCase\CreateTask
 */
class Interactor implements CreateTask
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
     * @param string $taskName
     * @return CreateTaskResult
     * @throws Exception
     */
    public function createTask(string $taskName): CreateTaskResult
    {
        $getUserResult = $this->currentUserProvider->getCurrentUser();
        $user = $getUserResult->getUser();

        $task = new Task(Uuid::uuid4(), $taskName, $user->getId());

        $saveTaskResult = $this->taskSaver->saveTask($task);
        $savedTask = $saveTaskResult->getTask();

        return new CreateTaskResult($savedTask);
    }
}
