<?php declare(strict_types=1);

namespace App\Tests\Unit\Entry\Api;

use App\Application\Domain\Task;
use App\Application\UseCase\RenameTask\RenameTask as RenameTaskUseCase;
use App\Application\UseCase\RenameTask\RenameTaskResult;
use App\Entry\Api\RenameTask as RenameTaskHandler;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RenameTaskTest
 * @package App\Tests\Unit\Entry\Api
 */
class RenameTaskTest extends TestCase
{
    /**
     * @var RenameTaskUseCase|MockObject
     */
    private $useCase;

    /**
     * @var RenameTaskHandler
     */
    private RenameTaskHandler $handler;

    protected function setUp(): void
    {
        $this->useCase = $this->createMock(RenameTaskUseCase::class);

        $this->handler = new RenameTaskHandler($this->useCase);
    }

    /**
     * @throws Exception
     */
    public function testRenameTaskWithSuccessfulResponse(): void
    {
        $taskUuid = '94164a7f-ce76-45f4-bb6a-a27932836ce9';
        $taskName = 'Task name';
        $task = new Task(Uuid::fromString($taskUuid), $taskName, Uuid::uuid4());

        $useCaseResult = RenameTaskResult::createSuccessfulResult($task);
        $this->setupUseCase($useCaseResult);
        $request = $this->createRequest($taskUuid, $taskName);

        $response = $this->handler->renameTask($request);

        $this->assertEquals(new JsonResponse($task->toArray()), $response);
    }

    /**
     * @dataProvider uuidExamples
     *
     * @param string $taskUuid
     * @throws Exception
     */
    public function testRenameTaskWithNotFoundResponse(string $taskUuid): void
    {
        $useCaseResult = RenameTaskResult::createFailedResult();
        $this->setupUseCase($useCaseResult);
        $request = $this->createRequest($taskUuid, 'Task name');

        $response = $this->handler->renameTask($request);

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
     * @param RenameTaskResult $expectedResult
     */
    private function setupUseCase(RenameTaskResult $expectedResult): void
    {
        $this
            ->useCase
            ->method('renameTask')
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
