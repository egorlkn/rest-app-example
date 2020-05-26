<?php declare(strict_types=1);

namespace App\Application\UseCase\AddNewTask;

/**
 * Interface InputData
 * @package App\Application\UseCase\AddNewTask
 */
interface InputData
{
    /**
     * @return string
     */
    public function getTaskName(): string;

    /**
     * @return bool
     */
    public function isCompletedTask(): bool;
}
