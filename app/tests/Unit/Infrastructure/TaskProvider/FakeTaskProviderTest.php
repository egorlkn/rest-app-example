<?php declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\TaskProvider;

use App\Application\Domain\User;
use App\Infrastructure\TaskProvider\FakeTaskProvider;
use Exception;
use LogicException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class FakeTaskProviderTest
 * @package App\Infrastructure\TaskProvider
 */
class FakeTaskProviderTest extends TestCase
{
    /**
     * @var FakeTaskProvider
     */
    private FakeTaskProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new FakeTaskProvider();
    }

    /**
     * @throws Exception
     */
    public function testGetTaskSuccessfulResult(): void
    {
        $taskId = Uuid::fromString('94164a7f-ce76-45f4-bb6a-a27932836ce9');
        $user = new User(Uuid::uuid4());

        $getTaskResult = $this->provider->getTask($taskId, $user);
        $this->assertTrue($getTaskResult->isSuccessful());

        $task = $getTaskResult->getTask();
        $this->assertSame($task->getId(), $taskId);
        $this->assertSame($task->getName(), 'Task one');
        $this->assertSame($task->getUserId(), $user->getId());
    }

    /**
     * @throws Exception
     */
    public function testGetTaskWithFailedResult(): void
    {
        $taskId = Uuid::fromString('e2c1c4fe-46d2-420a-a13b-20fbe4b68b63');
        $user = new User(Uuid::uuid4());

        $getTaskResult = $this->provider->getTask($taskId, $user);
        $this->assertFalse($getTaskResult->isSuccessful());

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Can not get Task from failed result');
        $getTaskResult->getTask();
    }
}
