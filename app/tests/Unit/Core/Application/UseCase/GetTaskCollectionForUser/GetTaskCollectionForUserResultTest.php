<?php declare(strict_types=1);

namespace App\Tests\Unit\Core\Application\UseCase\GetTaskCollectionForUser;

use App\Core\Application\UseCase\GetTaskCollectionForUser\GetTaskCollectionForUserResult;
use App\Core\Application\UseCase\GetTaskCollectionForUser\TaskProvider\TaskCollectionProviderResult;
use App\Core\Domain\TaskCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class GetTaskCollectionForUserResultTest
 * @package App\Tests\Unit\Core\Application\UseCase\GetTaskCollectionForUser
 */
class GetTaskCollectionForUserResultTest extends TestCase
{
    public function test(): void
    {
        /** @var TaskCollectionProviderResult|MockObject $taskCollectionProviderResult */
        $taskCollectionProviderResult = $this->createMock(TaskCollectionProviderResult::class);

        /** @var TaskCollection|MockObject $taskCollection */
        $taskCollection = $this->createMock(TaskCollection::class);
        $taskCollectionProviderResult->expects($this->once())->method('getTaskCollection')->willReturn($taskCollection);

        $result = new GetTaskCollectionForUserResult($taskCollectionProviderResult);

        $this->assertSame($taskCollection, $result->getTaskCollection());
    }
}
