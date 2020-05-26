<?php declare(strict_types=1);

namespace App\Tests\Functional\Entry\Api\ExistentTask;

use App\Entry\Api\ExistentTask\EditTask;
use Exception;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EditTaskTest
 * @package App\Tests\Functional\Entry\Api\ExistentTask
 * @covers \App\Entry\Api\ExistentTask\EditTask
 * @covers \App\Entry\Api\ExistentTask\EditTaskInputData
 */
class EditTaskTest extends KernelTestCase
{
    /**
     * @var EditTask
     */
    private $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->handler = self::$container->get(EditTask::class);
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testEditTaskWithSuccessfulResponse(): void
    {
        $taskUuid = '94164a7f-ce76-45f4-bb6a-a27932836ce9';
        $taskNewName = 'Task new name';
        $isCompletedTask = true;
        $request = $this->createRequest($taskUuid, $taskNewName, $isCompletedTask);

        $response = $this->handler->editTask($request);
        $this->assertTrue($response->isSuccessful());

        $content = $response->getContent();
        $this->assertJson($content);
        $this->assertSame(
            [
                'uuid' => $taskUuid,
                'name' => $taskNewName,
                'completed' => $isCompletedTask,
            ],
            json_decode($content, true, 512, JSON_THROW_ON_ERROR)
        );
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

        $response = $this->handler->editTask($request);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame(404, $response->getStatusCode());

        $content = $response->getContent();
        $this->assertEmpty($content);
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
     * @throws JsonException
     */
    public function testEditTaskWithBadRequestResponse(): void
    {
        $request = $this->createRequest('94164a7f-ce76-45f4-bb6a-a27932836ce9', '', true);

        $response = $this->handler->editTask($request);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame(400, $response->getStatusCode());

        $content = $response->getContent();
        $this->assertEmpty($content);
    }

    /**
     * @param string $taskUuid
     * @param string $taskNewName
     * @param bool $isCompletedTask
     * @return Request
     * @throws JsonException
     */
    private function createRequest(string $taskUuid, string $taskNewName, bool $isCompletedTask): Request
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
                    'completed' => $isCompletedTask,
                ],
                JSON_THROW_ON_ERROR
            )
        );
    }
}
