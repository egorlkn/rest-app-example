<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\GetTaskCollectionForUser\TaskProvider;

use App\Core\Domain\Task;
use App\Core\Domain\User;
use App\Infrastructure\GetTaskCollectionForUser\TaskProvider\FakeTaskCollectionProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class FakeTaskCollectionProviderTest
 * @package App\Tests\Infrastructure\GetTaskCollectionForUser\Repository
 */
class FakeTaskCollectionProviderTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test(): void
    {
        $userId = Uuid::uuid4();
        $user = $this->createUser($userId);

        $provider = new FakeTaskCollectionProvider();

        $providerResult = $provider->getCollectionByUser($user);

        $this->assertEquals(
            [
                new Task(Uuid::fromString('8e80aeaa-ae5b-4970-a54d-c5a29cc59a0e'), 'Task one', $userId),
                new Task(Uuid::fromString('e014b55e-8769-4a73-b7ea-81541abd7713'), 'Task two', $userId),
                new Task(Uuid::fromString('2af76c6a-a613-4f74-827d-f8e735f2e1ce'), 'Task three', $userId),
            ],
            $providerResult->getTaskCollection()->getArrayCopy()
        );
    }

    /**
     * @param UuidInterface $userId
     * @return User
     */
    private function createUser(UuidInterface $userId): User
    {
        /** @var User|MockObject $user */
        $user = $this->createMock(User::class);

        $user->expects($this->once())->method('getId')->willReturn($userId);

        return $user;
    }
}
