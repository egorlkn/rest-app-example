<?php declare(strict_types=1);

namespace App\Tests\Unit\Entry\Api\ExistentTask;

use App\Application\Domain\Task;
use App\Application\UseCase\EditTask\EditTask as EditTaskUseCase;
use App\Application\UseCase\EditTask\EditTaskResponse;
use App\Entry\Api\ExistentTask\EditTask as EditTaskRequestHandler;
use Exception;
use JsonException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class EditTaskTest
 * @package App\Tests\Unit\Entry\Api\ExistentTask
 */
class EditTaskTest extends TestCase
{
    /**
     * @var EditTaskUseCase|MockObject
     */
    private $useCase;

    /**
     * @var EditTaskRequestHandler
     */
    private EditTaskRequestHandler $handler;

    protected function setUp(): void
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $this->useCase = $this->createMock(EditTaskUseCase::class);

        $this->handler = new EditTaskRequestHandler($serializer, $this->useCase);
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testEditTaskWithSuccessfulResponse(): void
    {
        $taskUuid = Uuid::uuid4();
        $taskNewName = 'Task new name';
        $markedTaskAsCompleted = true;
        $request = $this->createRequest($taskUuid->toString(), $taskNewName, $markedTaskAsCompleted);

        $task = new Task($taskUuid, $taskNewName, Uuid::uuid4(), $markedTaskAsCompleted);
        $this->setupUseCase(EditTaskResponse::createSuccessfulResult($task));

        $response = $this->handler->editTask($request);

        $this->assertEquals(new JsonResponse($task->toArray()), $response);
    }

    /**
     * @dataProvider notFoundUuidExamples
     *
     * @param string $taskUuid
     * @throws JsonException
     */
    public function testEditTaskWithNotFoundResponse(string $taskUuid): void
    {
        $request = $this->createRequest($taskUuid, 'Task new name', true);

        $this->setupUseCase(EditTaskResponse::createFailedResult());

        $response = $this->handler->editTask($request);

        $this->assertEquals((new Response())->setStatusCode(Response::HTTP_NOT_FOUND), $response);
    }

    /**
     * @return array<array>
     */
    public function notFoundUuidExamples(): array
    {
        return [
            'invalid uuid' => ['123'],
            'non-existent uuid' => ['a231a630-2cbf-4e38-a8e7-618c928317f3'],
        ];
    }

    /**
     * @param EditTaskResponse $expectedResult
     */
    private function setupUseCase(EditTaskResponse $expectedResult): void
    {
        $this
            ->useCase
            ->method('editTask')
            ->willReturn($expectedResult);
    }

    /**
     * @param string $taskUuid
     * @param string $taskNewName
     * @param bool $markedTaskAsCompleted
     * @return Request
     * @throws JsonException
     */
    private function createRequest(string $taskUuid, string $taskNewName, bool $markedTaskAsCompleted): Request
    {
        return new Request(
            [
                'uuid' => $taskUuid,
            ],
            [],
            [],
            [],
            [],
            [],
            json_encode(
                [
                    'name' => $taskNewName,
                    'completed' => $markedTaskAsCompleted,
                ],
                JSON_THROW_ON_ERROR
            )
        );
    }
}
