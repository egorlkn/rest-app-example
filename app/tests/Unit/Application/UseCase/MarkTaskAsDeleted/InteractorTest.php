<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase\MarkTaskAsDeleted;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskProvider\TaskProviderResult;
use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\TaskSaver\TaskSaverResult;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Component\UserProvider\CurrentUserProviderResult;
use App\Application\Domain\Task;
use App\Application\Domain\User;
use App\Application\UseCase\MarkTaskAsDeleted\Interactor;
use Exception;
use LogicException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class InteractorTest
 * @package App\Tests\Unit\Application\UseCase\MarkTaskAsDeleted
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
    public function testMarkTaskAsDeletedWithSuccessfulResult(): void
    {
        $userUuid = Uuid::uuid4();
        $this->setupUserProvider($userUuid);

        $taskUuid = Uuid::uuid4();
        $this->setupTaskProviderWithSuccessfulResult($taskUuid, $userUuid);

        $this->setupTaskSaver($taskUuid, $userUuid);

        $markTaskResult = $this->interactor->markTaskAsDeleted($taskUuid);
        $this->assertTrue($markTaskResult->isSuccessful());

        $markedTask = $markTaskResult->getTask();
        $this->assertSame($taskUuid, $markedTask->getUuid());
        $this->assertSame($userUuid, $markedTask->getUserUuid());
        $this->assertTrue($markedTask->isDeleted());
    }

    /**
     * @throws Exception
     */
    public function testMarkTaskAsDeletedWithFailedResult(): void
    {
        $this->setupUserProvider(Uuid::uuid4());

        $this->setupTaskProviderWithFailedResult();

        $markTaskResult = $this->interactor->markTaskAsDeleted(Uuid::uuid4());
        $this->assertFalse($markTaskResult->isSuccessful());

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Can not get Task from failed result');
        $markTaskResult->getTask();
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
     * @param UuidInterface $userUuid
     */
    private function setupTaskProviderWithSuccessfulResult(UuidInterface $uuid, UuidInterface $userUuid): void
    {
        $task = new Task($uuid, '', $userUuid);

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
     */
    private function setupTaskSaver(UuidInterface $taskUuid, UuidInterface $userUuid): void
    {
        $savedTask = new Task($taskUuid, '', $userUuid, true, true);
        $taskSaverResult = new TaskSaverResult($savedTask);

        $this
            ->taskSaver
            ->expects($this->once())
            ->method('saveTask')
            ->willReturn($taskSaverResult);
    }
}
