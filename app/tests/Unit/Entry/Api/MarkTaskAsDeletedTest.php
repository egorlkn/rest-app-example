<?php declare(strict_types=1);

namespace App\Tests\Unit\Entry\Api;

use App\Application\Domain\Task;
use App\Application\UseCase\MarkTaskAsDeleted\MarkTaskAsDeleted as MarkTaskAsDeletedUseCase;
use App\Application\UseCase\MarkTaskAsDeleted\MarkTaskAsDeletedResult;
use App\Entry\Api\MarkTaskAsDeleted as MarkTaskAsDeletedHandler;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MarkTaskAsDeletedTest
 * @package App\Tests\Unit\Entry\Api
 */
class MarkTaskAsDeletedTest extends TestCase
{
    /**
     * @var MarkTaskAsDeletedUseCase|MockObject
     */
    private $useCase;

    /**
     * @var MarkTaskAsDeletedHandler
     */
    private MarkTaskAsDeletedHandler $handler;

    protected function setUp(): void
    {
        $this->useCase = $this->createMock(MarkTaskAsDeletedUseCase::class);

        $this->handler = new MarkTaskAsDeletedHandler($this->useCase);
    }

    /**
     * @throws Exception
     */
    public function testMarkTaskAsDeletedWithSuccessfulResponse(): void
    {
        $taskUuid = Uuid::uuid4();
        $request = $this->createRequest($taskUuid->toString());

        $task = new Task($taskUuid, '', Uuid::uuid4(), true, true);
        $this->setupUseCase(MarkTaskAsDeletedResult::createSuccessfulResult($task));

        $response = $this->handler->markTaskAsDeleted($request);

        $this->assertEquals(new JsonResponse($task->toArray()), $response);
    }

    /**
     * @dataProvider notFoundUuidExamples
     *
     * @param string $taskUuid
     */
    public function testMarkTaskAsDeletedWithNotFoundResponse(string $taskUuid): void
    {
        $request = $this->createRequest($taskUuid);

        $this->setupUseCase(MarkTaskAsDeletedResult::createFailedResult());

        $response = $this->handler->markTaskAsDeleted($request);

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
     * @param MarkTaskAsDeletedResult $expectedResult
     */
    private function setupUseCase(MarkTaskAsDeletedResult $expectedResult): void
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
        $request->attributes->set('uuid', $taskUuid);

        return $request;
    }
}
