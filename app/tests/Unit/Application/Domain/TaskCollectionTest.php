<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\Domain;

use App\Application\Domain\Task;
use App\Application\Domain\TaskCollection;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

/**
 * Class TaskCollectionTest
 * @package App\Tests\Unit\Application\Domain
 */
class TaskCollectionTest extends TestCase
{
    /**
     * @throws Exception
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
     */
    public function throwWhenTaskListIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected an instance of App\Application\Domain\Task. Got: stdClass');

        new TaskCollection(
            [
                new stdClass(),
                new stdClass(),
                new stdClass(),
            ]
        );
    }
}
