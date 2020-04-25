<?php declare(strict_types=1);

namespace App\Application\UseCase\GetTaskCollection\UserProvider;

use App\Application\Domain\User;

/**
 * Class CurrentUserProviderResult
 * @package App\Application\UseCase\GetTaskCollection\UserProvider
 */
class CurrentUserProviderResult
{
    /**
     * @var User
     */
    private User $user;

    /**
     * CurrentUserProviderResult constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
