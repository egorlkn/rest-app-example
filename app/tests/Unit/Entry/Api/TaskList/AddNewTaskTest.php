<?php declare(strict_types=1);

namespace App\Tests\Unit\Entry\Api\TaskList;

use App\Application\Domain\Task;
use App\Application\UseCase\AddNewTask\AddNewTask as AddNewTaskUseCase;
use App\Application\UseCase\AddNewTask\AddNewTaskResult;
use App\Entry\Api\TaskList\AddNewTask as AddNewTaskHandler;
use Exception;
use JsonException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class AddNewTaskTest
 * @package App\Tests\Unit\Entry\Api\TaskList
 */
class AddNewTaskTest extends TestCase
{
    /**
     * @var AddNewTaskUseCase|MockObject
     */
    private $useCase;

    /**
     * @var AddNewTaskHandler
     */
    private AddNewTaskHandler $handler;

    protected function setUp(): void
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $this->useCase = $this->createMock(AddNewTaskUseCase::class);

        $this->handler = new AddNewTaskHandler($serializer, $this->useCase);
    }

    /**
     * @throws Exception
     */
    public function testAddNewTask(): void
    {
        $task = new Task(Uuid::uuid4(), 'New task', Uuid::uuid4());

        $this->setupUseCase($task);

        $request = $this->createRequest($task);

        $response = $this->handler->addNewTask($request);

        $this->assertEquals(new JsonResponse($task->toArray()), $response);
    }

    /**
     * @param Task $task
     */
    private function setupUseCase(Task $task): void
    {
        $useCaseResult = new AddNewTaskResult($task);

        $this
            ->useCase
            ->expects($this->once())
            ->method('addNewTask')
            ->willReturn($useCaseResult);
    }

    /**
     * @param Task $task
     * @return Request
     * @throws JsonException
     */
    private function createRequest(Task $task): Request
    {
        return new Request(
            [],
            [],
            [],
            [],
            [],
            [],
            json_encode(
                [
                    'name' => $task->getName(),
                    'completed' => $task->isCompleted(),
                ],
                JSON_THROW_ON_ERROR
            )
        );
    }
}
