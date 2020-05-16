<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase\MarkTaskAsCompleted;

use App\Application\Component\TaskProvider\TaskProvider;
use App\Application\Component\TaskProvider\TaskProviderResult;
use App\Application\Component\TaskSaver\TaskSaver;
use App\Application\Component\TaskSaver\TaskSaverResult;
use App\Application\Component\UserProvider\CurrentUserProvider;
use App\Application\Component\UserProvider\CurrentUserProviderResult;
use App\Application\Domain\Task;
use App\Application\Domain\User;
use App\Application\UseCase\MarkTaskAsCompleted\Interactor;
use Exception;
use LogicException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class InteractorTest
 * @package App\Tests\Unit\Application\UseCase\MarkTaskAsCompleted
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
    public function testMarkTaskAsCompletedWithSuccessfulResult(): void
    {
        $userUuid = Uuid::uuid4();
        $this->setupUserProvider($userUuid);

        $taskUuid = Uuid::uuid4();
        $this->setupTaskProviderWithSuccessfulResult($taskUuid, $userUuid);

        $this->setupTaskSaver($taskUuid, $userUuid);

        $markTaskResult = $this->interactor->markTaskAsCompleted($taskUuid);
        $this->assertTrue($markTaskResult->isSuccessful());

        $markedTask = $markTaskResult->getTask();
        $this->assertSame($taskUuid, $markedTask->getUuid());
        $this->assertSame($userUuid, $markedTask->getUserUuid());
        $this->assertTrue($markedTask->isCompleted());
    }

    /**
     * @throws Exception
     */
    public function testMarkTaskAsCompletedWithFailedResult(): void
    {
        $this->setupUserProvider(Uuid::uuid4());

        $this->setupTaskProviderWithFailedResult();

        $markTaskResult = $this->interactor->markTaskAsCompleted(Uuid::uuid4());
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
        $task = new Task($taskUuid, '', $userUuid);
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
     * @param UuidInterface $userUuid
     */
    private function setupTaskSaver(UuidInterface $taskUuid, UuidInterface $userUuid): void
    {
        $savedTask = new Task($taskUuid, '', $userUuid, true);
        $taskSaverResult = new TaskSaverResult($savedTask);

        $this
            ->taskSaver
            ->expects($this->once())
            ->method('saveTask')
            ->willReturn($taskSaverResult);
    }
}
