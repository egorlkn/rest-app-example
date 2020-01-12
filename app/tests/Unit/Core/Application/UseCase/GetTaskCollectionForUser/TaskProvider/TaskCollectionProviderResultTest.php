<?php declare(strict_types=1);

namespace App\Tests\Unit\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider;

use App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider\TaskCollectionProviderResult;
use App\Core\Domain\Task;
use App\Core\Domain\TaskCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class TaskCollectionProviderResultTest
 * @package App\Tests\Unit\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider
 */
class TaskCollectionProviderResultTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test(): void
    {
        $taskCollection = new TaskCollection(
            [
                new Task(Uuid::uuid4(), 'Task one', Uuid::uuid4()),
                new Task(Uuid::uuid4(), 'Task one', Uuid::uuid4()),
            ]
        );

        $result = new TaskCollectionProviderResult($taskCollection);

        $this->assertSame($taskCollection, $result->getTaskCollection());
    }
}
