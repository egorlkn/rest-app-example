<?php declare(strict_types=1);

namespace App\Application\UseCase\GetTaskCollection\UserProvider;

/**
 * Interface CurrentUserProvider
 * @package App\Application\UseCase\GetTaskCollection\UserProvider
 */
interface CurrentUserProvider
{
    /**
     * @return CurrentUserProviderResult
     */
    public function getCurrentUser(): CurrentUserProviderResult;
}
