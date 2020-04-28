<?php declare(strict_types=1);

namespace App\Application\Component\UserProvider;

/**
 * Interface CurrentUserProvider
 * @package App\Application\Component\UserProvider
 */
interface CurrentUserProvider
{
    /**
     * @return CurrentUserProviderResult
     */
    public function getCurrentUser(): CurrentUserProviderResult;
}
