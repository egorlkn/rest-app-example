<?php declare(strict_types=1);

namespace App\Tests\Integration\Entry\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class GetTaskListTest
 * @package App\Tests\Integration\Entry\Api
 * @coversNothing
 */
class GetTaskListTest extends WebTestCase
{
    public function testGetTaskList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/1/task/list');

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());

        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertJson($content);
    }
}
