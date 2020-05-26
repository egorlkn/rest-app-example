<?php declare(strict_types=1);

namespace App\Tests\Unit\Entry\Api\ExistentTask;

use App\Application\Domain\Task;
use App\Application\UseCase\MarkTaskAsDeleted\MarkTaskAsDeleted as MarkTaskAsDeletedUseCase;
use App\Application\UseCase\MarkTaskAsDeleted\Result;
use App\Entry\Api\ExistentTask\DeleteTask as DeleteTaskRequestHandler;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DeleteTaskTest
 * @package App\Tests\Unit\Entry\Api\ExistentTask
 */
class DeleteTaskTest extends TestCase
{
    /**
     * @var MarkTaskAsDeletedUseCase|MockObject
     */
    private $useCase;

    /**
     * @var DeleteTaskRequestHandler
     */
    private DeleteTaskRequestHandler $handler;

    protected function setUp(): void
    {
        $this->useCase = $this->createMock(MarkTaskAsDeletedUseCase::class);

        $this->handler = new DeleteTaskRequestHandler($this->useCase);
    }

    /**
     * @throws Exception
     */
    public function testDeleteTaskWithSuccessfulResponse(): void
    {
        $taskUuid = Uuid::uuid4();
        $request = $this->createRequest($taskUuid->toString());

        $task = new Task($taskUuid, '', Uuid::uuid4(), true, true);
        $this->setupUseCase(Result::createSuccessfulResult($task));

        $response = $this->handler->deleteTask($request);

        $this->assertEquals((new Response())->setStatusCode(Response::HTTP_NO_CONTENT), $response);
    }

    /**
     * @dataProvider notFoundUuidExamples
     *
     * @param string $taskUuid
     */
    public function testDeleteTaskWithNotFoundResponse(string $taskUuid): void
    {
        $request = $this->createRequest($taskUuid);

        $this->setupUseCase(Result::createFailedResult());

        $response = $this->handler->deleteTask($request);

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
     * @param Result $expectedResult
     */
    private function setupUseCase(Result $expectedResult): void
    {
        $this
            ->useCase
            ->method('markTaskAsDeleted')
            ->willReturn($expectedResult);
    }

    /**
     * @param string $taskUuid
     * @return Request
     */
    private function createRequest(string $taskUuid): Request
    {
        $request = new Request();
        $request->query->set('uuid', $taskUuid);

        return $request;
    }
}
