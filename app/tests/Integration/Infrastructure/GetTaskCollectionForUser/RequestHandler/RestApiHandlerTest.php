<?php declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\GetTaskCollectionForUser\RequestHandler;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class RestApiHandlerTest
 * @package App\Tests\Integration\Infrastructure\GetTaskCollectionForUser\RequestHandler
 * @coversNothing
 */
class RestApiHandlerTest extends WebTestCase
{
    public function testGetTaskCollectionForUser(): void
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
