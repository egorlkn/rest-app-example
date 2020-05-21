<?php declare(strict_types=1);

namespace App\Tests\Functional\Entry\Api\TaskList;

use App\Entry\Api\TaskList\AddNewTask;
use JsonException;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AddNewTaskTest
 * @package App\Tests\Functional\Entry\Api\TaskList
 * @covers \App\Entry\Api\TaskList\AddNewTask
 * @covers \App\Entry\Api\TaskList\AddNewTaskInputData
 */
class AddNewTaskTest extends KernelTestCase
{
    /**
     * @var AddNewTask
     */
    private $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->handler = self::$container->get(AddNewTask::class);
    }

    /**
     * @throws JsonException
     */
    public function testAddNewTaskWithSuccessfulResponse(): void
    {
        $taskName = 'New task';
        $isCompletedTask = false;

        $request = $this->createRequest($taskName, $isCompletedTask);

        $response = $this->handler->addNewTask($request);
        $this->assertTrue($response->isSuccessful());

        $content = $response->getContent();
        $this->assertJson($content);

        $contentData = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $this->assertArrayHasKey('uuid', $contentData);
        $this->assertTrue(Uuid::isValid($contentData['uuid']));
        $this->assertArrayHasKey('name', $contentData);
        $this->assertSame($taskName, $contentData['name']);
        $this->assertArrayHasKey('completed', $contentData);
        $this->assertSame($isCompletedTask, $contentData['completed']);
    }

    /**
     * @throws JsonException
     */
    public function testAddNewTaskWithBadRequestResponse(): void
    {
        $request = $this->createRequest('', true);

        $response = $this->handler->addNewTask($request);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame(400, $response->getStatusCode());

        $content = $response->getContent();
        $this->assertEmpty($content);
    }

    /**
     * @param string $taskName
     * @param bool $isCompletedTask
     * @return Request
     * @throws JsonException
     */
    private function createRequest(string $taskName, bool $isCompletedTask): Request
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
                    'name' => $taskName,
                    'completed' => $isCompletedTask,
                ],
                JSON_THROW_ON_ERROR
            )
        );
    }
}
