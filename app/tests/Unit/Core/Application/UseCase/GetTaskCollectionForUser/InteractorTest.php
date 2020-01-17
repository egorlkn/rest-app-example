<?php

namespace App\Tests\Unit\Core\Application\UseCase\GetTaskCollectionForUser;

use App\Core\Application\UseCase\GetTaskCollectionForUser\Interactor;
use App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider\TaskCollectionProvider;
use App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider\TaskCollectionProviderResult;
use App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider\CurrentUserProvider;
use App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider\CurrentUserProviderResult;
use App\Core\Domain\Task;
use App\Core\Domain\TaskCollection;
use App\Core\Domain\User;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class InteractorTest
 * @package App\Tests\Unit\Core\Application\UseCase\GetTaskCollectionForUserId
 */
class InteractorTest extends TestCase
{
    /**
     * @var CurrentUserProvider|MockObject
     */
    private $currentUserProvider;

    /**
     * @var TaskCollectionProvider|MockObject
     */
    private $taskCollectionProvider;

    /**
     * @var Interactor
     */
    private Interactor $interactor;

    protected function setUp(): void
    {
        $this->currentUserProvider = $this->createMock(CurrentUserProvider::class);
        $this->taskCollectionProvider = $this->createMock(TaskCollectionProvider::class);

        $this->interactor = new Interactor($this->currentUserProvider, $this->taskCollectionProvider);
    }

    /**
     * @throws Exception
     */
    public function testGetCollection(): void
    {
        $this->setupUserProvider();

        $taskCollection = new TaskCollection(
            [
                new Task(Uuid::uuid4(), 'Task one', Uuid::uuid4()),
                new Task(Uuid::uuid4(), 'Task one', Uuid::uuid4()),
            ]
        );
        $this->setupTaskProvider($taskCollection);

        $getTaskCollectionForUserResult = $this->interactor->getCollection();

        $this->assertSame($taskCollection, $getTaskCollectionForUserResult->getTaskCollection());
    }

    /**
     * @throws Exception
     */
    private function setupUserProvider(): void
    {
        $user = new User(Uuid::uuid4());

        $currentUserProviderResult = $this->createMock(CurrentUserProviderResult::class);
        $currentUserProviderResult
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user);

        $this
            ->currentUserProvider
            ->expects($this->once())
            ->method('getCurrentUser')
            ->willReturn($currentUserProviderResult);
    }

    /**
     * @param TaskCollection $taskCollection
     */
    private function setupTaskProvider(TaskCollection $taskCollection): void
    {
        $taskCollectionProviderResult = $this->createMock(TaskCollectionProviderResult::class);
        $taskCollectionProviderResult
            ->expects($this->once())
            ->method('getTaskCollection')
            ->willReturn($taskCollection);

        $this
            ->taskCollectionProvider
            ->expects($this->once())
            ->method('getCollectionByUser')
            ->willReturn($taskCollectionProviderResult);
    }
}
