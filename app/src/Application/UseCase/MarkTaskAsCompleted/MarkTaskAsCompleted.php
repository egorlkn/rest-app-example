<?php declare(strict_types=1);

namespace App\Application\UseCase\MarkTaskAsCompleted;

use Ramsey\Uuid\UuidInterface;

/**
 * Interface MarkTaskAsCompleted
 * @package App\Application\UseCase\MarkTaskAsCompleted
 */
interface MarkTaskAsCompleted
{
    /**
     * @param UuidInterface $taskUuid
     * @return MarkTaskAsCompletedResult
     */
    public function markTaskAsCompleted(UuidInterface $taskUuid): MarkTaskAsCompletedResult;
}
