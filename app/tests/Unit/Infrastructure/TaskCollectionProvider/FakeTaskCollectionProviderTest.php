<?php declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\TaskCollectionProvider;

use App\Application\Domain\Task;
use App\Application\Domain\User;
use App\Infrastructure\TaskCollectionProvider\FakeTaskCollectionProvider;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class FakeTaskCollectionProviderTest
 * @package App\Tests\Unit\Infrastructure\TaskCollectionProvider
 */
class FakeTaskCollectionProviderTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetCollection(): void
    {
        $userId = Uuid::uuid4();
        $user = new User($userId);

        $provider = new FakeTaskCollectionProvider();

        $providerResult = $provider->getCollection($user);

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
     * @throws Exception
     */
    public function testGetCollectionWithDeletedTasks(): void
    {
        $userId = Uuid::uuid4();
        $user = new User($userId);

        $provider = new FakeTaskCollectionProvider();

        $providerResult = $provider->getCollection($user, true);

        $this->assertEquals(
            [
                new Task(Uuid::fromString('8e80aeaa-ae5b-4970-a54d-c5a29cc59a0e'), 'Task one', $userId),
                new Task(Uuid::fromString('e014b55e-8769-4a73-b7ea-81541abd7713'), 'Task two', $userId),
                new Task(Uuid::fromString('2af76c6a-a613-4f74-827d-f8e735f2e1ce'), 'Task three', $userId),
                new Task(Uuid::fromString('8a5c1bf0-f911-4880-ab76-2a14e75066cc'), 'Task four', $userId, true),
                new Task(Uuid::fromString('e908dba1-fb8e-4509-b1fc-8e6f96b48819'), 'Task five', $userId, true),
            ],
            $providerResult->getTaskCollection()->getArrayCopy()
        );
    }
}
