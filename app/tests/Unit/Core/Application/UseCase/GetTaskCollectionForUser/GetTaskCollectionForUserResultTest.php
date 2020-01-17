<?php declare(strict_types=1);

namespace App\Tests\Unit\Core\Application\UseCase\GetTaskCollectionForUser;

use App\Core\Application\UseCase\GetTaskCollectionForUser\GetTaskCollectionForUserResult;
use App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider\TaskCollectionProviderResult;
use App\Core\Domain\Task;
use App\Core\Domain\TaskCollection;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class GetTaskCollectionForUserResultTest
 * @package App\Tests\Unit\Core\Application\UseCase\GetTaskCollectionForUser
 */
class GetTaskCollectionForUserResultTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test(): void
    {
        $taskCollection = new TaskCollection(
            [
                new Task(Uuid::uuid4(), 'Task one', Uuid::uuid4()),
                new Task(Uuid::uuid4(), 'Task two', Uuid::uuid4()),
            ]
        );

        /** @var TaskCollectionProviderResult|MockObject $taskCollectionProviderResult */
        $taskCollectionProviderResult = $this->createMock(TaskCollectionProviderResult::class);
        $taskCollectionProviderResult
            ->expects($this->once())
            ->method('getTaskCollection')
            ->willReturn($taskCollection);

        $result = new GetTaskCollectionForUserResult($taskCollectionProviderResult);

        $this->assertSame($taskCollection, $result->getTaskCollection());
    }
}
