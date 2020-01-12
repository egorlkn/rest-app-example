<?php declare(strict_types=1);

namespace App\Tests\Unit\Core\Domain;

use App\Core\Domain\Task;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class TaskTest
 * @package App\Tests\Unit\Core\Domain
 */
class TaskTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test(): void
    {
        $id = Uuid::uuid4();
        $name = 'Name';

        $task = new Task($id, $name, Uuid::uuid4());

        $this->assertSame(
            [
                'id' => $id->toString(),
                'name' => $name,
            ],
            $task->toArray()
        );
    }
}
