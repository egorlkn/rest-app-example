<?php declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\TaskSaver;

use App\Application\Domain\Task;
use App\Infrastructure\TaskSaver\FakeTaskSaver;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class FakeTaskSaverTest
 * @package App\Tests\Unit\Infrastructure\TaskSaver
 */
class FakeTaskSaverTest extends TestCase
{
    /**
     * @var FakeTaskSaver
     */
    private FakeTaskSaver $saver;

    protected function setUp(): void
    {
        $this->saver = new FakeTaskSaver();
    }

    /**
     * @throws Exception
     */
    public function testSaveTask(): void
    {
        $task = new Task(Uuid::uuid4(), 'Task one', Uuid::uuid4());

        $saveTaskResult = $this->saver->saveTask($task);

        $this->assertSame($task, $saveTaskResult->getTask());
    }
}
