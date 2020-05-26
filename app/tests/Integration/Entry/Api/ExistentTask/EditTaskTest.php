<?php declare(strict_types=1);

namespace App\Tests\Integration\Entry\Api\ExistentTask;

use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class EditTaskTest
 * @package App\Tests\Integration\Entry\Api\ExistentTask
 * @coversNothing
 */
class EditTaskTest extends WebTestCase
{
    /**
     * @throws JsonException
     */
    public function testEditTaskWithSuccessfulResponse(): void
    {
        $client = static::createClient();
        $client->request(
            'PUT',
            '/api/1/task/94164a7f-ce76-45f4-bb6a-a27932836ce9',
            [],
            [],
            [],
            json_encode(
                [
                    'name' => 'Task new name',
                    'completed' => true,
                ],
                JSON_THROW_ON_ERROR
            )
        );

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());

        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertJson($content);
    }

    /**
     * @dataProvider notFoundUuidExamples
     *
     * @param string $taskUuid
     * @throws JsonException
     */
    public function testEditTaskWithNotFoundResponse(string $taskUuid): void
    {
        $client = static::createClient();
        $client->request(
            'PUT',
            sprintf('/api/1/task/%s', $taskUuid),
            [],
            [],
            [],
            json_encode(
                [
                    'name' => 'Task new name',
                    'completed' => true,
                ],
                JSON_THROW_ON_ERROR
            )
        );

        $response = $client->getResponse();
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
        $client = static::createClient();
        $client->request(
            'PUT',
            '/api/1/task/94164a7f-ce76-45f4-bb6a-a27932836ce9',
            [],
            [],
            [],
            json_encode(
                [
                    'name' => '',
                    'completed' => true,
                ],
                JSON_THROW_ON_ERROR
            )
        );

        $response = $client->getResponse();
        $this->assertFalse($response->isSuccessful());
        $this->assertSame(400, $response->getStatusCode());

        $content = $response->getContent();
        $this->assertEmpty($content);
    }
}
