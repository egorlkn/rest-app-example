<?php

namespace App\Tests\Core\Application\UseCase\GetTaskCollectionForUserId;

use App\Core\Application\UseCase\GetTaskCollectionForUser\Interactor;
use App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider\TaskCollectionProvider;
use App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider\TaskCollectionProviderResult;
use App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider\CurrentUserProvider;
use App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider\CurrentUserProviderResult;
use App\Core\Domain\TaskCollection;
use App\Core\Domain\User;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class InteractorTest
 * @package App\Tests\Core\Application\UseCase\GetTaskCollectionForUserId
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
    private $interactor;

    protected function setUp(): void
    {
        $this->currentUserProvider = $this->createMock(CurrentUserProvider::class);
        $this->taskCollectionProvider = $this->createMock(TaskCollectionProvider::class);

        $this->interactor = new Interactor($this->currentUserProvider, $this->taskCollectionProvider);
    }

    /**
     * @throws \Exception
     */
    public function testGetCollection(): void
    {
        /**
         * @var User|MockObject $user
         * @var TaskCollection|MockObject $taskCollection
         */
        $user = $this->createMock(User::class);
        $taskCollection = $this->createMock(TaskCollection::class);

        $this->setupUserProvider($user);
        $this->setupTaskProvider($taskCollection);

        $getTaskCollectionForUserResult = $this->interactor->getCollection();

        $this->assertSame($taskCollection, $getTaskCollectionForUserResult->getTaskCollection());
    }

    /**
     * @param User $user
     */
    private function setupUserProvider(User $user): void
    {
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
