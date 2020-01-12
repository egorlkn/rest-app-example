<?php declare(strict_types=1);

namespace App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider;

/**
 * Interface CurrentUserProvider
 * @package App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider
 */
interface CurrentUserProvider
{
    /**
     * @return CurrentUserProviderResult
     */
    public function getCurrentUser(): CurrentUserProviderResult;
}
