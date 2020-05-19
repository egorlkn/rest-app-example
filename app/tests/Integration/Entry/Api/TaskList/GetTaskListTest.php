<?php declare(strict_types=1);

namespace App\Tests\Integration\Entry\Api\TaskList;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class GetTaskListTest
 * @package App\Tests\Integration\Entry\Api\TaskList
 * @coversNothing
 */
class GetTaskListTest extends WebTestCase
{
    public function testGetTaskList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/1/tasks');

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());

        $content = $response->getContent();
        $this->assertNotEmpty($content);
        $this->assertJson($content);
    }
}
