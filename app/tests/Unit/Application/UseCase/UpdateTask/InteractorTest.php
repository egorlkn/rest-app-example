<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase\UpdateTask;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskProvider\TaskProviderResult;
use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\TaskSaver\TaskSaverResult;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Component\UserProvider\CurrentUserProviderResult;
use App\Application\Domain\Task;
use App\Application\Domain\User;
use App\Application\UseCase\UpdateTask\Interactor;
use Exception;
use LogicException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class InteractorTest
 * @package App\Tests\Unit\Application\UseCase\UpdateTask
 */
class InteractorTest extends TestCase
{
    /**
     * @var CurrentUserProvider|MockObject
     */
    private $currentUserProvider;

    /**
     * @var TaskProvider|MockObject
     */
    private $taskProvider;

    /**
     * @var TaskSaver|MockObject
     */
    private $taskSaver;

    /**
     * @var Interactor
     */
    private Interactor $interactor;

    protected function setUp(): void
    {
        $this->currentUserProvider = $this->createMock(CurrentUserProvider::class);
        $this->taskProvider = $this->createMock(TaskProvider::class);
        $this->taskSaver = $this->createMock(TaskSaver::class);

        $this->interactor = new Interactor(
            $this->currentUserProvider,
            $this->taskProvider,
            $this->taskSaver
        );
    }

    /**
     * @throws Exception
     */
    public function testUpdateTask(): void
    {
        $userUuid = Uuid::uuid4();
        $this->setupUserProvider($userUuid);

        $taskUuid = Uuid::uuid4();
        $this->setupTaskProviderWithSuccessfulResult($taskUuid, $userUuid);

        $newTaskName = 'New task one';
        $this->setupTaskSaver($taskUuid, $newTaskName, $userUuid);

        $updateTaskResult = $this->interactor->updateTask($taskUuid, $newTaskName);
        $this->assertTrue($updateTaskResult->isSuccessful());

        $updatedTask = $updateTaskResult->getTask();
        $this->assertSame($taskUuid, $updatedTask->getId());
        $this->assertSame($newTaskName, $updatedTask->getName());
        $this->assertSame($userUuid, $updatedTask->getUserId());
    }

    /**
     * @throws Exception
     */
    public function testFailedUpdateTask(): void
    {
        $this->setupUserProvider(Uuid::uuid4());

        $this->setupTaskProviderWithFailedResult();

        $updateTaskResult = $this->interactor->updateTask(Uuid::uuid4(), 'New task one');
        $this->assertFalse($updateTaskResult->isSuccessful());

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Can not get Task from failed result');
        $updateTaskResult->getTask();
    }

    /**
     * @param UuidInterface $uuid
     */
    private function setupUserProvider(UuidInterface $uuid): void
    {
        $user = new User($uuid);
        $currentUserProviderResult = new CurrentUserProviderResult($user);

        $this
            ->currentUserProvider
            ->expects($this->once())
            ->method('getCurrentUser')
            ->willReturn($currentUserProviderResult);
    }

    /**
     * @param UuidInterface $taskUuid
     * @param UuidInterface $userUuid
     */
    private function setupTaskProviderWithSuccessfulResult(UuidInterface $taskUuid, UuidInterface $userUuid): void
    {
        $task = new Task($taskUuid, 'Task one', $userUuid);
        $taskProviderResult = TaskProviderResult::createSuccessfulResult($task);

        $this
            ->taskProvider
            ->expects($this->once())
            ->method('getTask')
            ->willReturn($taskProviderResult);
    }

    private function setupTaskProviderWithFailedResult(): void
    {
        $taskProviderFailedResult = TaskProviderResult::createFailedResult();

        $this
            ->taskProvider
            ->expects($this->once())
            ->method('getTask')
            ->willReturn($taskProviderFailedResult);
    }

    /**
     * @param UuidInterface $taskUuid
     * @param string $taskName
     * @param UuidInterface $userUuid
     */
    private function setupTaskSaver(UuidInterface $taskUuid, string $taskName, UuidInterface $userUuid): void
    {
        $savedTask = new Task($taskUuid, $taskName, $userUuid);
        $taskSaverResult = new TaskSaverResult($savedTask);

        $this
            ->taskSaver
            ->expects($this->once())
            ->method('saveTask')
            ->willReturn($taskSaverResult);
    }
}
