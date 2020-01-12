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
        $taskOne = new Task(Uuid::uuid4(), 'Task one', Uuid::uuid4());
        $taskTwo = new Task(Uuid::uuid4(), 'Task two', Uuid::uuid4());

        $taskCollection = new TaskCollection(
            [
                $taskOne,
                $taskTwo,
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
                    $taskOne->toArray(),
                    $taskTwo->toArray(),
                ]
            ),
            $response
        );
    }
}
