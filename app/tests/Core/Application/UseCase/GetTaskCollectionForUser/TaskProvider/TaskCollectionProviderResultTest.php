<?php declare(strict_types=1);

namespace App\Tests\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider;

use App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider\TaskCollectionProviderResult;
use App\Core\Domain\TaskCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class TaskCollectionProviderResultTest
 * @package App\Tests\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider
 */
class TaskCollectionProviderResultTest extends TestCase
{
    public function test(): void
    {
        /** @var TaskCollection|MockObject $taskCollection */
        $taskCollection = $this->createMock(TaskCollection::class);

        $result = new TaskCollectionProviderResult($taskCollection);

        $this->assertSame($taskCollection, $result->getTaskCollection());
    }
}
