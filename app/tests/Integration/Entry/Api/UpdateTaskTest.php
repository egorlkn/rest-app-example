<?php declare(strict_types=1);

namespace App\Tests\Integration\Entry\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UpdateTaskTest
 * @package App\Tests\Integration\Entry\Api
 * @coversNothing
 */
class UpdateTaskTest extends WebTestCase
{
    public function testUpdateTaskWithSuccessfulResponse(): void
    {
        $client = static::createClient();
        $client->request('PUT', '/api/1/task/94164a7f-ce76-45f4-bb6a-a27932836ce9/update', ['name' => 'Upd task one']);

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame($response->getStatusCode(), 200);

        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertJson($content);
    }

    public function testUpdateTaskWithNotFoundResponse(): void
    {
        $client = static::createClient();
        $client->request('PUT', '/api/1/task/123/update', ['name' => 'Upd task one']);

        $response = $client->getResponse();
        $this->assertFalse($response->isSuccessful());
        $this->assertSame($response->getStatusCode(), 404);

        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertJsonStringEqualsJsonString('"Task is not found"', $content);
    }
}
