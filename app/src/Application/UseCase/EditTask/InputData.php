<?php declare(strict_types=1);

namespace App\Application\UseCase\EditTask;

use Ramsey\Uuid\UuidInterface;

/**
 * Interface InputData
 * @package App\Application\UseCase\EditTask
 */
interface InputData
{
    /**
     * @return UuidInterface
     */
    public function getTaskUuid(): UuidInterface;

    /**
     * @return string
     */
    public function getTaskName(): string;

    /**
     * @return bool
     */
    public function isCompletedTask(): bool;
}
