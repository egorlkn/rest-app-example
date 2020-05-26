<?php declare(strict_types=1);

namespace App\Application\UseCase\MarkTaskAsDeleted;

use Ramsey\Uuid\UuidInterface;

/**
 * Interface MarkTaskAsDeleted
 * @package App\Application\UseCase\MarkTaskAsDeleted
 */
interface MarkTaskAsDeleted
{
    /**
     * @param UuidInterface $taskUuid
     * @return Result
     */
    public function markTaskAsDeleted(UuidInterface $taskUuid): Result;
}
