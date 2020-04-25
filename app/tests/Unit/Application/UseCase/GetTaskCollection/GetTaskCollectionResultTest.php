<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase\GetTaskCollection;

use App\Application\Domain\Task;
use App\Application\Domain\TaskCollection;
use App\Application\UseCase\GetTaskCollection\GetTaskCollectionResult;
use App\Application\UseCase\GetTaskCollection\TaskProvider\TaskCollectionProviderResult;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class GetTaskCollectionResultTest
 * @package App\Tests\Unit\Application\UseCase\GetTaskCollection
 */
class GetTaskCollectionResultTest extends TestCase
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

        $result = new GetTaskCollectionResult($taskCollectionProviderResult);

        $this->assertSame($taskCollection, $result->getTaskCollection());
    }
}
