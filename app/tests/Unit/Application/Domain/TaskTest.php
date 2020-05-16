<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\Domain;

use App\Application\Domain\Task;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class TaskTest
 * @package App\Tests\Unit\Application\Domain
 */
class TaskTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testToArray(): void
    {
        $uuid = Uuid::uuid4();
        $name = 'Name';

        $task = new Task($uuid, $name, Uuid::uuid4());

        $this->assertSame(
            [
                'uuid' => $uuid->toString(),
                'name' => $name,
            ],
            $task->toArray()
        );
    }
}
