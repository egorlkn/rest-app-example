<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase\CreateTask;

use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\TaskSaver\TaskSaverResult;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Component\UserProvider\CurrentUserProviderResult;
use App\Application\Domain\Task;
use App\Application\Domain\User;
use App\Application\UseCase\CreateTask\Interactor;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class InteractorTest
 * @package App\Tests\Unit\Application\UseCase\CreateTask
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
    public function testCreateTask(): void
    {
        $userUuid = Uuid::uuid4();
        $this->setupUserProvider($userUuid);

        $taskName = 'Task one';
        $this->setupTaskSaver($taskName, $userUuid);

        $createTaskResult = $this->interactor->createTask($taskName);
        $task = $createTaskResult->getTask();

        $this->assertTrue(Uuid::isValid($task->getUuid()));
        $this->assertSame($taskName, $task->getName());
        $this->assertSame($userUuid, $task->getUserUuid());
        $this->assertFalse($task->isCompleted());
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
     * @param UuidInterface $userUuid
     * @throws Exception
     */
    private function setupTaskSaver(string $taskName, UuidInterface $userUuid): void
    {
        $savedTask = new Task(Uuid::uuid4(), $taskName, $userUuid);
        $taskSaverResult = new TaskSaverResult($savedTask);

        $this
            ->taskSaver
            ->expects($this->once())
            ->method('saveTask')
            ->willReturn($taskSaverResult);
    }
}
