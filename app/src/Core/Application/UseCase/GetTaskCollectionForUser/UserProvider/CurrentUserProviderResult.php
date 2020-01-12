<?php declare(strict_types=1);

namespace App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider;

use App\Core\Domain\User;

/**
 * Class CurrentUserProviderResult
 * @package App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider
 */
class CurrentUserProviderResult
{
    /**
     * @var User
     */
    private $user;

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
