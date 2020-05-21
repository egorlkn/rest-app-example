<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase\EditTask;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskProvider\TaskProviderResult;
use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\TaskSaver\TaskSaverResult;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Component\UserProvider\CurrentUserProviderResult;
use App\Application\Domain\Task;
use App\Application\Domain\User;
use App\Application\UseCase\EditTask\InputData;
use App\Application\UseCase\EditTask\Interactor;
use Exception;
use LogicException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class InteractorTest
 * @package App\Tests\Unit\Application\UseCase\EditTask
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
    private $taskSaver;

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
    public function testEditTaskWithSuccessfulResult(): void
    {
        $userUuid = Uuid::uuid4();
        $this->setupUserProvider($userUuid);

        $taskUuid = Uuid::uuid4();
        $this->setupTaskProviderWithSuccessfulResult($taskUuid, $userUuid);

        $taskNewName = 'Task new name';
        $isCompletedTask = true;
        $this->setupTaskSaver($taskUuid, $taskNewName, $isCompletedTask, $userUuid);

        $inputData = $this->createInputData($taskUuid, $taskNewName, $isCompletedTask);

        $editTaskResult = $this->interactor->editTask($inputData);
        $this->assertTrue($editTaskResult->isSuccessful());

        $editedTask = $editTaskResult->getTask();
        $this->assertSame($taskUuid, $editedTask->getUuid());
        $this->assertSame($taskNewName, $editedTask->getName());
        $this->assertSame($userUuid, $editedTask->getUserUuid());
        $this->assertSame($isCompletedTask, $editedTask->isCompleted());
    }

    /**
     * @throws Exception
     */
    public function testEditTaskWithFailedResult(): void
    {
        $this->setupUserProvider(Uuid::uuid4());

        $this->setupTaskProviderWithFailedResult();

        $inputData = $this->createInputData(Uuid::uuid4());

        $editTaskResult = $this->interactor->editTask($inputData);
        $this->assertFalse($editTaskResult->isSuccessful());

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Can not get Task from failed result');
        $editTaskResult->getTask();
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
     * @param UuidInterface $taskUuid
     * @param UuidInterface $userUuid
     */
    private function setupTaskProviderWithSuccessfulResult(
        UuidInterface $taskUuid,
        UuidInterface $userUuid
    ): void {
        $task = new Task($taskUuid, 'Task old name', $userUuid);

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
     * @param string $taskNewName
     * @param bool $isCompletedTask
     * @param UuidInterface $userUuid
     */
    private function setupTaskSaver(
        UuidInterface $taskUuid,
        string $taskNewName,
        bool $isCompletedTask,
        UuidInterface $userUuid
    ): void {
        $savedTask = new Task($taskUuid, $taskNewName, $userUuid, $isCompletedTask);
        $taskSaverResult = new TaskSaverResult($savedTask);

        $this
            ->taskSaver
            ->expects($this->once())
            ->method('saveTask')
            ->willReturn($taskSaverResult);
    }

    /**
     * @param UuidInterface $taskUuid
     * @param string|null $taskName
     * @param bool|null $isCompletedTask
     * @return InputData|MockObject
     */
    private function createInputData(
        UuidInterface $taskUuid,
        string $taskName = null,
        bool $isCompletedTask = null
    ): InputData {
        /** @var InputData|MockObject $inputData */
        $inputData = $this->createMock(InputData::class);

        $inputData
            ->expects($this->once())
            ->method('getTaskUuid')
            ->willReturn($taskUuid);

        if (is_string($taskName)) {
            $inputData
                ->expects($this->once())
                ->method('getTaskName')
                ->willReturn($taskName);
        }

        if (is_bool($isCompletedTask)) {
            $inputData
                ->expects($this->once())
                ->method('isCompletedTask')
                ->willReturn($isCompletedTask);
        }

        return $inputData;
    }
}
