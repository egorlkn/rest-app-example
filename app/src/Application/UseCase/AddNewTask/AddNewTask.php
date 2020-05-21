<?php declare(strict_types=1);

namespace App\Application\UseCase\AddNewTask;

/**
 * Interface AddNewTask
 * @package App\Application\UseCase\AddNewTask
 */
interface AddNewTask
{
    /**
     * @param InputData $inputData
     * @return Result
     */
    public function addNewTask(InputData $inputData): Result;
}
