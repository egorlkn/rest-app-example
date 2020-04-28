<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase\CreateTask;

use App\Application\Domain\Task;
use App\Application\UseCase\CreateTask\CreateTaskResult;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class CreateTaskResultTest
 * @package App\Tests\Unit\Application\UseCase\CreateTask
 */
class CreateTaskResultTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test(): void
    {
        $task = new Task(Uuid::uuid4(), 'Task one', Uuid::uuid4());

        $result = new CreateTaskResult($task);

        $this->assertSame($task, $result->getTask());
    }
}
