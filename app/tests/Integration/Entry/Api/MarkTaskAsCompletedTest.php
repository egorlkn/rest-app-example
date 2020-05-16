<?php declare(strict_types=1);

namespace App\Tests\Integration\Entry\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class MarkTaskAsCompletedTest
 * @package App\Tests\Integration\Entry\Api
 * @coversNothing
 */
class MarkTaskAsCompletedTest extends WebTestCase
{
    public function testMarkTaskAsCompletedWithSuccessfulResponse(): void
    {
        $client = static::createClient();
        $client->request('PUT', '/api/1/task/94164a7f-ce76-45f4-bb6a-a27932836ce9/complete');

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame($response->getStatusCode(), 200);

        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertJson($content);
    }

    /**
     * @dataProvider notFoundUuidExamples
     *
     * @param string $taskUuid
     */
    public function testMarkTaskAsCompletedWithNotFoundResponse(string $taskUuid): void
    {
        $client = static::createClient();
        $client->request('PUT', sprintf('/api/1/task/%s/complete', $taskUuid));

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
