<?php declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\TaskProvider;

use App\Application\Domain\User;
use App\Infrastructure\TaskProvider\FakeTaskProvider;
use Exception;
use LogicException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

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
     * @dataProvider successfulTaskExamples
     *
     * @param UuidInterface $taskUuid
     * @param string $taskName
     * @param User $user
     * @param bool $deleted
     */
    public function testGetTaskWithSuccessfulResult(
        UuidInterface $taskUuid,
        string $taskName,
        User $user,
        bool $deleted
    ): void {
        $getTaskResult = $this->provider->getTask($taskUuid, $user, $deleted);
        $this->assertTrue($getTaskResult->isSuccessful());

        $task = $getTaskResult->getTask();
        $this->assertSame($task->getId(), $taskUuid);
        $this->assertSame($task->getName(), $taskName);
        $this->assertSame($task->getUserId(), $user->getId());
        $this->assertSame($task->isDeleted(), $deleted);
    }

    /**
     * @return array<array>
     * @throws Exception
     */
    public function successfulTaskExamples(): array
    {
        $user = new User(Uuid::uuid4());

        return [
            'active task' => [Uuid::fromString('94164a7f-ce76-45f4-bb6a-a27932836ce9'), 'Task one', $user, false],
            'deleted task' => [Uuid::fromString('f5fa3e5f-cf2e-42a9-a2db-370dcb5384c6'), 'Task two', $user, true],
        ];
    }

    /**
     * @dataProvider failedTaskExamples
     *
     * @param UuidInterface $taskUuid
     * @param User $user
     * @param bool $deleted
     */
    public function testGetTaskWithFailedResult(
        UuidInterface $taskUuid,
        User $user,
        bool $deleted
    ): void {
        $getTaskResult = $this->provider->getTask($taskUuid, $user, $deleted);
        $this->assertFalse($getTaskResult->isSuccessful());

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Can not get Task from failed result');
        $getTaskResult->getTask();
    }

    /**
     * @return array<array>
     * @throws Exception
     */
    public function failedTaskExamples(): array
    {
        $user = new User(Uuid::uuid4());

        return [
            'deleted task' => [Uuid::fromString('f5fa3e5f-cf2e-42a9-a2db-370dcb5384c6'), $user, false],
            'non-existent task' => [Uuid::fromString('1bf713a2-cb9f-4bdb-be29-4921042d3836'), $user, true],
        ];
    }
}
