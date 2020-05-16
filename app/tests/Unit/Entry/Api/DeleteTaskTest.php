<?php declare(strict_types=1);

namespace App\Tests\Unit\Entry\Api;

use App\Application\UseCase\DeleteTask\DeleteTask as DeleteTaskUseCase;
use App\Application\UseCase\DeleteTask\DeleteTaskResult;
use App\Entry\Api\DeleteTask as DeleteTaskHandler;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeleteTaskTest
 * @package App\Tests\Unit\Entry\Api
 */
class DeleteTaskTest extends TestCase
{
    /**
     * @var DeleteTaskUseCase|MockObject
     */
    private $useCase;

    /**
     * @var DeleteTaskHandler
     */
    private DeleteTaskHandler $handler;

    protected function setUp(): void
    {
        $this->useCase = $this->createMock(DeleteTaskUseCase::class);

        $this->handler = new DeleteTaskHandler($this->useCase);
    }

    /**
     * @throws Exception
     */
    public function testDeleteTaskWith200Response(): void
    {
        $request = $this->createRequest(Uuid::uuid4()->toString());

        $this->setupUseCase(DeleteTaskResult::createSuccessfulResult());

        $response = $this->handler->deleteTask($request);

        $this->assertEquals(new JsonResponse('Task was deleted', 200), $response);
    }

    /**
     * @dataProvider notFoundUuidExamples
     *
     * @param string $taskUuid
     */
    public function testDeleteTaskWith404Response(string $taskUuid): void
    {
        $request = $this->createRequest($taskUuid);

        $this->setupUseCase(DeleteTaskResult::createNotFoundResult());

        $response = $this->handler->deleteTask($request);

        $this->assertEquals(new JsonResponse('Task is not found', 404), $response);
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
     * @throws Exception
     */
    public function testDeleteTaskWith500Response(): void
    {
        $request = $this->createRequest(Uuid::uuid4()->toString());

        $this->setupUseCase(DeleteTaskResult::createFailedResult());

        $response = $this->handler->deleteTask($request);

        $this->assertEquals(new JsonResponse('Task is not deleted', 500), $response);
    }

    /**
     * @param DeleteTaskResult $expectedResult
     */
    private function setupUseCase(DeleteTaskResult $expectedResult): void
    {
        $this
            ->useCase
            ->method('deleteTask')
            ->willReturn($expectedResult);
    }

    /**
     * @param string $taskUuid
     * @return Request
     */
    private function createRequest(string $taskUuid): Request
    {
        $request = new Request();
        $request->attributes->set('uuid', $taskUuid);

        return $request;
    }
}
