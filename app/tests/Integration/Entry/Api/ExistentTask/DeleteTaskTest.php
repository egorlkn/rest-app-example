<?php declare(strict_types=1);

namespace App\Tests\Integration\Entry\Api\ExistentTask;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DeleteTaskTest
 * @package App\Tests\Integration\Entry\Api\ExistentTask
 * @coversNothing
 */
class DeleteTaskTest extends WebTestCase
{
    public function testDeleteTaskWithSuccessfulResponse(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/1/task/94164a7f-ce76-45f4-bb6a-a27932836ce9');

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame($response->getStatusCode(), 204);

        $content = $response->getContent();
        $this->assertEmpty($content);
    }

    /**
     * @dataProvider notFoundUuidExamples
     *
     * @param string $taskUuid
     */
    public function testDeleteTaskWithNotFoundResponse(string $taskUuid): void
    {
        $client = static::createClient();
        $client->request('DELETE', sprintf('/api/1/task/%s', $taskUuid));

        $response = $client->getResponse();
        $this->assertFalse($response->isSuccessful());
        $this->assertSame($response->getStatusCode(), 404);

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
}
