<?php declare(strict_types=1);

namespace App\Tests\Unit\Entry\Api;

use App\Application\Domain\Task;
use App\Application\UseCase\CreateTask\CreateTask as CreateTaskUseCase;
use App\Application\UseCase\CreateTask\CreateTaskResult;
use App\Entry\Api\CreateTask as CreateTaskHandler;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateTaskTest
 * @package App\Tests\Unit\Entry\Api
 */
class CreateTaskTest extends TestCase
{
    /**
     * @var CreateTaskUseCase|MockObject
     */
    private $useCase;

    /**
     * @var CreateTaskHandler
     */
    private CreateTaskHandler $handler;

    protected function setUp(): void
    {
        $this->useCase = $this->createMock(CreateTaskUseCase::class);

        $this->handler = new CreateTaskHandler($this->useCase);
    }

    /**
     * @throws Exception
     */
    public function testCreateTask(): void
    {
        $taskName = 'Task name';
        $task = new Task(Uuid::uuid4(), $taskName, Uuid::uuid4());

        $useCaseResult = new CreateTaskResult($task);

        $this
            ->useCase
            ->expects($this->once())
            ->method('createTask')
            ->willReturn($useCaseResult);

        $request = $this->createRequest($taskName);

        $response = $this->handler->createTask($request);

        $this->assertEquals(new JsonResponse($task->toArray()), $response);
    }

    /**
     * @param string $taskName
     * @return Request
     */
    private function createRequest(string $taskName): Request
    {
        $request = new Request();
        $request->request->set('name', $taskName);

        return $request;
    }
}
