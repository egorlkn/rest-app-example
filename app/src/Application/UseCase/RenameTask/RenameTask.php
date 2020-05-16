<?php declare(strict_types=1);

namespace App\Application\UseCase\RenameTask;

use Ramsey\Uuid\UuidInterface;

/**
 * Interface RenameTask
 * @package App\Application\UseCase\RenameTask
 */
interface RenameTask
{
    /**
     * @param UuidInterface $taskId
     * @param string $newTaskName
     * @return RenameTaskResult
     */
    public function renameTask(UuidInterface $taskId, string $newTaskName): RenameTaskResult;
}
