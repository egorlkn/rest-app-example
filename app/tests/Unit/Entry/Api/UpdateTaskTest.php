<?php declare(strict_types=1);

namespace App\Tests\Unit\Entry\Api;

use App\Application\Domain\Task;
use App\Application\UseCase\UpdateTask\UpdateTask as UpdateTaskUseCase;
use App\Application\UseCase\UpdateTask\UpdateTaskResult;
use App\Entry\Api\UpdateTask as UpdateTaskHandler;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UpdateTaskTest
 * @package App\Tests\Unit\Entry\Api
 */
class UpdateTaskTest extends TestCase
{
    /**
     * @var UpdateTaskUseCase|MockObject
     */
    private $useCase;

    /**
     * @var UpdateTaskHandler
     */
    private UpdateTaskHandler $handler;

    protected function setUp(): void
    {
        $this->useCase = $this->createMock(UpdateTaskUseCase::class);

        $this->handler = new UpdateTaskHandler($this->useCase);
    }

    /**
     * @throws Exception
     */
    public function testUpdateTaskWithSuccessfulResponse(): void
    {
        $taskUuid = '94164a7f-ce76-45f4-bb6a-a27932836ce9';
        $taskName = 'Task name';
        $task = new Task(Uuid::fromString($taskUuid), $taskName, Uuid::uuid4());

        $useCaseResult = UpdateTaskResult::createSuccessfulResult($task);
        $this->setupUseCase($useCaseResult);
        $request = $this->createRequest($taskUuid, $taskName);

        $response = $this->handler->updateTask($request);

        $this->assertEquals(new JsonResponse($task->toArray()), $response);
    }

    /**
     * @dataProvider uuidExamples
     *
     * @param string $taskUuid
     * @throws Exception
     */
    public function testUpdateTaskWithNotFoundResponse(string $taskUuid): void
    {
        $useCaseResult = UpdateTaskResult::createFailedResult();
        $this->setupUseCase($useCaseResult);
        $request = $this->createRequest($taskUuid, 'Task name');

        $response = $this->handler->updateTask($request);

        $this->assertEquals(new JsonResponse('Task is not found', 404), $response);
    }

    /**
     * @return array<array>
     */
    public function uuidExamples(): array
    {
        return [
            ['123'],
            ['e2c1c4fe-46d2-420a-a13b-20fbe4b68b63'],
        ];
    }

    /**
     * @param UpdateTaskResult $expectedResult
     */
    private function setupUseCase(UpdateTaskResult $expectedResult): void
    {
        $this
            ->useCase
            ->method('updateTask')
            ->willReturn($expectedResult);
    }

    /**
     * @param string $taskUuid
     * @param string $taskName
     * @return Request
     */
    private function createRequest(string $taskUuid, string $taskName): Request
    {
        $request = new Request();
        $request->attributes->set('uuid', $taskUuid);
        $request->request->set('name', $taskName);

        return $request;
    }
}
