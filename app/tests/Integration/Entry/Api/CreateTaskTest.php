<?php declare(strict_types=1);

namespace App\Tests\Integration\Entry\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CreateTaskTest
 * @package App\Tests\Integration\Entry\Api
 * @coversNothing
 */
class CreateTaskTest extends WebTestCase
{
    public function testCreateTask(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/1/task/create', ['name' => 'Task one']);

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());

        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertJson($content);
    }
}
