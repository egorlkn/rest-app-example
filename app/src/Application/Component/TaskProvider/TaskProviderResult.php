<?php declare(strict_types=1);

namespace App\Application\Component\TaskProvider;

use App\Application\Domain\Task;
use LogicException;

/**
 * Class TaskProviderResult
 * @package App\Application\Component\TaskProvider
 */
class TaskProviderResult
{
    /**
     * @var Task
     */
    private Task $task;

    private function __construct() {}

    /**
     * @param Task $task
     * @return self
     */
    public static function createSuccessfulResult(Task $task): self
    {
        $result = new self();
        $result->task = $task;

        return $result;
    }

    /**
     * @return self
     */
    public static function createFailedResult(): self
    {
        return new self();
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return isset($this->task);
    }

    /**
     * @return Task
     * @throws LogicException
     */
    public function getTask(): Task
    {
        if (!$this->isSuccessful()) {
            throw new LogicException('Can not get Task from failed result');
        }

        return $this->task;
    }
}
