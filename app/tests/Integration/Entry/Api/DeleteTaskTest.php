<?php declare(strict_types=1);

namespace App\Tests\Integration\Entry\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DeleteTaskTest
 * @package App\Tests\Integration\Entry\Api
 * @coversNothing
 */
class DeleteTaskTest extends WebTestCase
{
    public function testDeleteTaskWith200Response(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/1/task/94164a7f-ce76-45f4-bb6a-a27932836ce9/delete');

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame($response->getStatusCode(), 200);

        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertJsonStringEqualsJsonString('"Task was deleted"', $content);
    }

    /**
     * @dataProvider notFoundUuidExamples
     *
     * @param string $taskUuid
     */
    public function testDeleteTaskWith404Response(string $taskUuid): void
    {
        $client = static::createClient();
        $client->request('DELETE', sprintf('/api/1/task/%s/delete', $taskUuid));

        $response = $client->getResponse();
        $this->assertFalse($response->isSuccessful());
        $this->assertSame($response->getStatusCode(), 404);

        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertJsonStringEqualsJsonString('"Task is not found"', $content);
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
