<?php declare(strict_types=1);

namespace App\Tests\Unit\Entry\Api;

use App\Application\Domain\Task;
use App\Application\UseCase\MarkTaskAsCompleted\MarkTaskAsCompleted as MarkTaskAsCompletedUseCase;
use App\Application\UseCase\MarkTaskAsCompleted\MarkTaskAsCompletedResult;
use App\Entry\Api\MarkTaskAsCompleted as MarkTaskAsCompletedHandler;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MarkTaskAsCompletedTest
 * @package App\Tests\Unit\Entry\Api
 */
class MarkTaskAsCompletedTest extends TestCase
{
    /**
     * @var MarkTaskAsCompletedUseCase|MockObject
     */
    private $useCase;

    /**
     * @var MarkTaskAsCompletedHandler
     */
    private MarkTaskAsCompletedHandler $handler;

    protected function setUp(): void
    {
        $this->useCase = $this->createMock(MarkTaskAsCompletedUseCase::class);

        $this->handler = new MarkTaskAsCompletedHandler($this->useCase);
    }

    /**
     * @throws Exception
     */
    public function testMarkTaskAsCompletedWithSuccessfulResponse(): void
    {
        $taskUuid = Uuid::uuid4();
        $request = $this->createRequest($taskUuid->toString());

        $task = new Task($taskUuid, '', Uuid::uuid4(), true, false);
        $this->setupUseCase(MarkTaskAsCompletedResult::createSuccessfulResult($task));

        $response = $this->handler->markTaskAsCompleted($request);

        $this->assertEquals(new JsonResponse($task->toArray()), $response);
    }

    /**
     * @dataProvider notFoundUuidExamples
     *
     * @param string $taskUuid
     */
    public function testMarkTaskAsCompletedWithFailedResponse(string $taskUuid): void
    {
        $request = $this->createRequest($taskUuid);

        $this->setupUseCase(MarkTaskAsCompletedResult::createFailedResult());

        $response = $this->handler->markTaskAsCompleted($request);

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
     * @param MarkTaskAsCompletedResult $expectedResult
     */
    private function setupUseCase(MarkTaskAsCompletedResult $expectedResult): void
    {
        $this
            ->useCase
            ->method('markTaskAsCompleted')
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
