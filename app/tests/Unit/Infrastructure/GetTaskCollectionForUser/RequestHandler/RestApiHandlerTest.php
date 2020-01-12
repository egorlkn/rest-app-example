<?php declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\GetTaskCollectionForUser\RequestHandler;

use App\Core\Application\UseCase\GetTaskCollectionForUser\GetTaskCollectionForUser;
use App\Core\Application\UseCase\GetTaskCollectionForUser\GetTaskCollectionForUserResult;
use App\Core\Domain\Task;
use App\Core\Domain\TaskCollection;
use App\Infrastructure\GetTaskCollectionForUser\RequestHandler\RestApiHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class RestApiHandlerTest
 * @package App\Tests\Unit\Infrastructure\GetTaskCollectionForUser\RequestHandler
 */
class RestApiHandlerTest extends TestCase
{
    /**
     * @var GetTaskCollectionForUser|MockObject
     */
    private $useCase;

    /**
     * @var RestApiHandler
     */
    private $handler;

    protected function setUp()
    {
        $this->useCase = $this->createMock(GetTaskCollectionForUser::class);

        $this->handler = new RestApiHandler($this->useCase);
    }

    /**
     * @throws \Exception
     */
    public function testGetTaskCollectionForUser(): void
    {
        $taskOneId = Uuid::uuid4();
        $taskOneName = 'Test task one';

        $taskTwoId = Uuid::uuid4();
        $taskTwoName = 'Test task one';

        $taskCollection = $this->createTaskCollectionMock(
            [
                $this->createTaskMock($taskOneId, $taskOneName),
                $this->createTaskMock($taskTwoId, $taskTwoName),
            ]
        );

        $useCaseResult = $this->createMock(GetTaskCollectionForUserResult::class);
        $useCaseResult
            ->expects($this->once())
            ->method('getTaskCollection')
            ->willReturn($taskCollection);

        $this
            ->useCase
            ->expects($this->once())
            ->method('getCollection')
            ->willReturn($useCaseResult);

        $response = $this->handler->getTaskCollectionForUser();

        $this->assertEquals(
            new JsonResponse(
                [
                    [
                        'id' => $taskOneId,
                        'name' => $taskOneName,
                    ],
                    [
                        'id' => $taskTwoId,
                        'name' => $taskTwoName,
                    ],
                ]
            ),
            $response
        );
    }

    /**
     * @param UuidInterface $id
     * @param string $name
     * @return Task|MockObject
     */
    private function createTaskMock(UuidInterface $id, string $name)
    {
        /** @var Task|MockObject $task */
        $task = $this->createMock(Task::class);

        $task->expects($this->once())->method('toArray')->willReturn(
            [
                'id' => $id->toString(),
                'name' => $name,
            ]
        );

        return $task;
    }

    /**
     * @param Task[]|MockObject[] $taskList
     * @return TaskCollection|MockObject
     */
    private function createTaskCollectionMock(array $taskList)
    {
        $iterator = new \ArrayIterator($taskList);

        /** @var TaskCollection|MockObject $taskCollection */
        $taskCollection = $this->createMock(TaskCollection::class);

        $taskCollection
            ->method('rewind')
            ->willReturnCallback(function () use ($iterator): void {
                $iterator->rewind();
            });

        $taskCollection
            ->method('current')
            ->willReturnCallback(function () use ($iterator) {
                return $iterator->current();
            });

        $taskCollection
            ->method('key')
            ->willReturnCallback(function () use ($iterator) {
                return $iterator->key();
            });

        $taskCollection
            ->method('next')
            ->willReturnCallback(function () use ($iterator): void {
                $iterator->next();
            });

        $taskCollection
            ->method('valid')
            ->willReturnCallback(function () use ($iterator): bool {
                return $iterator->valid();
            });

        return $taskCollection;
    }
}
