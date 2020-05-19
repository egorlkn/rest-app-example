<?php declare(strict_types=1);

namespace App\Tests\Integration\Entry\Api\TaskList;

use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AddNewTaskTest
 * @package App\Tests\Integration\Entry\Api\TaskList
 * @coversNothing
 */
class AddNewTaskTest extends WebTestCase
{
    /**
     * @throws JsonException
     */
    public function testAddNewTask(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/1/tasks',
            [],
            [],
            [],
            json_encode(
                [
                    'name' => 'New task',
                    'completed' => false,
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
}
