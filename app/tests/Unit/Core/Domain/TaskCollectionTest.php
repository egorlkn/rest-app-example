<?php declare(strict_types=1);

namespace App\Tests\Unit\Core\Domain;

use App\Core\Domain\Task;
use App\Core\Domain\TaskCollection;
use PHPUnit\Framework\TestCase;

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
            $this->createMock(Task::class),
            $this->createMock(Task::class),
            $this->createMock(Task::class),
        ];

        $taskCollection = new TaskCollection($taskList);

        $this->assertSame($taskList, $taskCollection->getArrayCopy());
        $taskCollection->next();
        $this->assertSame($taskList[1], $taskCollection->current());
        $this->assertSame($taskList[2], $taskCollection->offsetGet(2));
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
