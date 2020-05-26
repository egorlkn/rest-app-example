<?php declare(strict_types=1);

namespace App\Application\UseCase\GetTaskCollection;

/**
 * Interface GetTaskCollection
 * @package App\Application\UseCase\GetTaskCollection
 */
interface GetTaskCollection
{
    /**
     * @return Result
     */
    public function getCollection(): Result;
}
