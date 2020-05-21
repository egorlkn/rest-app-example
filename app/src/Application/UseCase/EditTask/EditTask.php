<?php declare(strict_types=1);

namespace App\Application\UseCase\EditTask;

/**
 * Interface EditTask
 * @package App\Application\UseCase\EditTask
 */
interface EditTask
{
    /**
     * @param InputData $inputData
     * @return Result
     */
    public function editTask(InputData $inputData): Result;
}
