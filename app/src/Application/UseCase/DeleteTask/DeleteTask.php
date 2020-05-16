<?php declare(strict_types=1);

namespace App\Application\UseCase\DeleteTask;

use Ramsey\Uuid\UuidInterface;

/**
 * Interface DeleteTask
 * @package App\Application\UseCase\DeleteTask
 */
interface DeleteTask
{
    /**
     * @param UuidInterface $taskUuid
     * @return DeleteTaskResult
     */
    public function deleteTask(UuidInterface $taskUuid): DeleteTaskResult;
}
