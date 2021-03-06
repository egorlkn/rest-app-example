<?php declare(strict_types=1);

namespace App\Tests\Unit\Entry\Api\TaskList;

use App\Application\Domain\Task;
use App\Application\Domain\TaskCollection;
use App\Application\UseCase\GetTaskCollection\GetTaskCollection;
use App\Application\UseCase\GetTaskCollection\Result;
use App\Entry\Api\TaskList\GetTaskList;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GetTaskListTest
 * @package App\Tests\Unit\Entry\Api\TaskList
 */
class GetTaskListTest extends TestCase
{
    /**
     * @var GetTaskCollection|MockObject
     */
    private $useCase;

    /**
     * @var GetTaskList
     */
    private GetTaskList $handler;

    protected function setUp(): void
    {
        $this->useCase = $this->createMock(GetTaskCollection::class);

        $this->handler = new GetTaskList($this->useCase);
    }

    /**
     * @throws Exception
     */
    public function testGetTaskList(): void
    {
        $taskOne = new Task(Uuid::uuid4(), 'Task one', Uuid::uuid4());
        $taskTwo = new Task(Uuid::uuid4(), 'Task two', Uuid::uuid4());

        $taskCollection = new TaskCollection(
            [
                $taskOne,
                $taskTwo,
            ]
        );

        $useCaseResult = new Result($taskCollection);

        $this
            ->useCase
            ->expects($this->once())
            ->method('getCollection')
            ->willReturn($useCaseResult);

        $response = $this->handler->getTaskList();

        $this->assertEquals(
            new JsonResponse(
                [
                    $taskOne->toArray(),
                    $taskTwo->toArray(),
                ]
            ),
            $response
        );
    }
}
