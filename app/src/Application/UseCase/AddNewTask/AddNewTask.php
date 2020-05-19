<?php declare(strict_types=1);

namespace App\Application\UseCase\AddNewTask;

/**
 * Interface AddNewTask
 * @package App\Application\UseCase\AddNewTask
 */
interface AddNewTask
{
    /**
     * @param AddNewTaskRequest $addNewTaskRequest
     * @return AddNewTaskResult
     */
    public function addNewTask(AddNewTaskRequest $addNewTaskRequest): AddNewTaskResult;
}
