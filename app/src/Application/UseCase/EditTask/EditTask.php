<?php declare(strict_types=1);

namespace App\Application\UseCase\EditTask;

use Ramsey\Uuid\UuidInterface;

/**
 * Interface EditTask
 * @package App\Application\UseCase\EditTask
 */
interface EditTask
{
    /**
     * @param UuidInterface $taskUuid
     * @param EditTaskRequest $request
     * @return EditTaskResponse
     */
    public function editTask(UuidInterface $taskUuid, EditTaskRequest $request): EditTaskResponse;
}
