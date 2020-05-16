<?php declare(strict_types=1);

namespace App\Tests\Integration\Entry\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class RenameTaskTest
 * @package App\Tests\Integration\Entry\Api
 * @coversNothing
 */
class RenameTaskTest extends WebTestCase
{
    public function testRenameTaskWithSuccessfulResponse(): void
    {
        $client = static::createClient();
        $client->request('PUT', '/api/1/task/94164a7f-ce76-45f4-bb6a-a27932836ce9/rename', ['name' => 'Upd task one']);

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame($response->getStatusCode(), 200);

        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertJson($content);
    }

    public function testRenameTaskWithNotFoundResponse(): void
    {
        $client = static::createClient();
        $client->request('PUT', '/api/1/task/123/rename', ['name' => 'Upd task one']);

        $response = $client->getResponse();
        $this->assertFalse($response->isSuccessful());
        $this->assertSame($response->getStatusCode(), 404);

        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertJsonStringEqualsJsonString('"Task is not found"', $content);
    }
}
