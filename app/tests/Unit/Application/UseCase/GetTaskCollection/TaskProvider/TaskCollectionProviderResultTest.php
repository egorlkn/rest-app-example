<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase\GetTaskCollection\TaskProvider;

use App\Application\Domain\Task;
use App\Application\Domain\TaskCollection;
use App\Application\UseCase\GetTaskCollection\TaskProvider\TaskCollectionProviderResult;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class TaskCollectionProviderResultTest
 * @package App\Tests\Unit\Application\UseCase\GetTaskCollection\TaskProvider
 */
class TaskCollectionProviderResultTest extends TestCase
{
    /**
     * @throws Exception
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
