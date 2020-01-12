<?php declare(strict_types=1);

namespace App\Core\Application\UseCase\GetTaskCollectionForUser;

/**
 * Interface GetTaskCollection
 * @package App\Core\Application\UseCase\GetTaskCollectionForUser
 */
interface GetTaskCollectionForUser
{
    /**
     * @return GetTaskCollectionForUserResult
     */
    public function getCollection(): GetTaskCollectionForUserResult;
}
