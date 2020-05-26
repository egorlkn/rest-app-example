<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase\AddNewTask;

use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\TaskSaver\TaskSaverResult;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Component\UserProvider\CurrentUserProviderResult;
use App\Application\Domain\Task;
use App\Application\Domain\User;
use App\Application\UseCase\AddNewTask\InputData;
use App\Application\UseCase\AddNewTask\Interactor;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class InteractorTest
 * @package App\Tests\Unit\Application\UseCase\AddNewTask
 */
class InteractorTest extends TestCase
{
    /**
     * @var CurrentUserProvider|MockObject
     */
    private $currentUserProvider;

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
        $this->taskSaver = $this->createMock(TaskSaver::class);

        $this->interactor = new Interactor($this->currentUserProvider, $this->taskSaver);
    }

    /**
     * @throws Exception
     */
    public function testAddNewTask(): void
    {
        $userUuid = Uuid::uuid4();
        $this->setupUserProvider($userUuid);

        $taskName = 'Task one';
        $isCompletedTask = false;
        $this->setupTaskSaver($taskName, $isCompletedTask, $userUuid);

        $inputData = $this->createInputData($taskName, $isCompletedTask);

        $result = $this->interactor->addNewTask($inputData);
        $task = $result->getTask();

        $this->assertTrue(Uuid::isValid($task->getUuid()));
        $this->assertSame($taskName, $task->getName());
        $this->assertSame($userUuid, $task->getUserUuid());
        $this->assertSame($isCompletedTask, $task->isCompleted());
        $this->assertFalse($task->isDeleted());
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
     * @param string $taskName
     * @param bool $isCompletedTask
     * @param UuidInterface $userUuid
     * @throws Exception
     */
    private function setupTaskSaver(string $taskName, bool $isCompletedTask, UuidInterface $userUuid): void
    {
        $savedTask = new Task(Uuid::uuid4(), $taskName, $userUuid, $isCompletedTask);
        $taskSaverResult = new TaskSaverResult($savedTask);

        $this
            ->taskSaver
            ->expects($this->once())
            ->method('saveTask')
            ->willReturn($taskSaverResult);
    }

    /**
     * @param string $taskName
     * @param bool $isCompletedTask
     * @return InputData|MockObject
     */
    private function createInputData(string $taskName, bool $isCompletedTask): InputData
    {
        /** @var InputData|MockObject $inputData */
        $inputData = $this->createMock(InputData::class);

        $inputData
            ->expects($this->once())
            ->method('getTaskName')
            ->willReturn($taskName);

        $inputData
            ->expects($this->once())
            ->method('isCompletedTask')
            ->willReturn($isCompletedTask);

        return $inputData;
    }
}
