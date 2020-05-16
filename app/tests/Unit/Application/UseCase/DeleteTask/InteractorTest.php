<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase\DeleteTask;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskProvider\TaskProviderResult;
use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\TaskSaver\TaskSaverResult;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Component\UserProvider\CurrentUserProviderResult;
use App\Application\Domain\Task;
use App\Application\Domain\User;
use App\Application\UseCase\DeleteTask\Interactor;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class InteractorTest
 * @package App\Tests\Unit\Application\UseCase\DeleteTask
 */
class InteractorTest extends TestCase
{
    /**
     * @var CurrentUserProvider|MockObject
     */
    private $userProvider;

    /**
     * @var TaskProvider|MockObject
     */
    private $taskProvider;

    /**
     * @var TaskSaver|MockObject
     */
    private TaskSaver $taskSaver;

    /**
     * @var Interactor
     */
    private Interactor $interactor;

    protected function setUp(): void
    {
        $this->userProvider = $this->createMock(CurrentUserProvider::class);
        $this->taskProvider = $this->createMock(TaskProvider::class);
        $this->taskSaver = $this->createMock(TaskSaver::class);

        $this->interactor = new Interactor(
            $this->userProvider,
            $this->taskProvider,
            $this->taskSaver
        );
    }

    /**
     * @throws Exception
     */
    public function testDeleteTaskWithSuccessfulResult(): void
    {
        $userUuid = Uuid::uuid4();
        $this->setupUserProvider($userUuid);

        $taskUuid = Uuid::uuid4();
        $this->setupTaskProviderWithSuccessfulResult($taskUuid);

        $this->setupTaskSaver($taskUuid, $userUuid, true);

        $deleteTaskResult = $this->interactor->deleteTask($taskUuid);

        $this->assertTrue($deleteTaskResult->isSuccessful());
    }

    /**
     * @throws Exception
     */
    public function testDeleteTaskWithFailedResult(): void
    {
        $this->setupUserProvider(Uuid::uuid4());

        $this->setupTaskProviderWithFailedResult();

        $deleteTaskResult = $this->interactor->deleteTask(Uuid::uuid4());

        $this->assertFalse($deleteTaskResult->isSuccessful());
    }

    /**
     * @param UuidInterface $uuid
     */
    private function setupUserProvider(UuidInterface $uuid): void
    {
        $user = new User($uuid);

        $getUserResult = new CurrentUserProviderResult($user);

        $this
            ->userProvider
            ->expects($this->once())
            ->method('getCurrentUser')
            ->willReturn($getUserResult);
    }

    /**
     * @param UuidInterface $uuid
     * @throws Exception
     */
    private function setupTaskProviderWithSuccessfulResult(UuidInterface $uuid): void
    {
        $task = new Task($uuid, 'Task name', Uuid::uuid4());

        $getTaskResult = TaskProviderResult::createSuccessfulResult($task);

        $this
            ->taskProvider
            ->expects($this->once())
            ->method('getTask')
            ->willReturn($getTaskResult);
    }

    private function setupTaskProviderWithFailedResult(): void
    {
        $this
            ->taskProvider
            ->expects($this->once())
            ->method('getTask')
            ->willReturn(TaskProviderResult::createFailedResult());
    }

    /**
     * @param UuidInterface $taskUuid
     * @param UuidInterface $userUuid
     * @param bool $completedTask
     */
    private function setupTaskSaver(UuidInterface $taskUuid, UuidInterface $userUuid, bool $completedTask): void
    {
        $savedTask = new Task($taskUuid, '', $userUuid, $completedTask, true);
        $taskSaverResult = new TaskSaverResult($savedTask);

        $this
            ->taskSaver
            ->expects($this->once())
            ->method('saveTask')
            ->willReturn($taskSaverResult);
    }
}
