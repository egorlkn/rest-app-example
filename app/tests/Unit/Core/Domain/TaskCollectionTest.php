<?php declare(strict_types=1);

namespace App\Tests\Unit\Core\Domain;

use App\Core\Domain\Task;
use App\Core\Domain\TaskCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class TaskCollectionTest
 * @package App\Tests\Unit\Core\Domain
 */
class TaskCollectionTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testConstruct(): void
    {
        $taskList = [
            new Task(Uuid::uuid4(), 'Task one', Uuid::uuid4()),
            new Task(Uuid::uuid4(), 'Task one', Uuid::uuid4()),
        ];

        $taskCollection = new TaskCollection($taskList);

        $this->assertSame($taskList, $taskCollection->getArrayCopy());
        $taskCollection->next();
        $this->assertSame($taskList[1], $taskCollection->current());
        $this->assertSame($taskList[0], $taskCollection->offsetGet(0));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected an instance of App\Core\Domain\Task. Got: stdClass
     */
    public function throwWhenTaskListIsInvalid(): void
    {
        new TaskCollection(
            [
                new \stdClass(),
                new \stdClass(),
                new \stdClass(),
            ]
        );
    }
}
