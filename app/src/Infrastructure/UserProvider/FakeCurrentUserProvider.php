<?php declare(strict_types=1);

namespace App\Infrastructure\UserProvider;

use App\Application\Domain\User;
use App\Application\UseCase\GetTaskCollection\UserProvider\CurrentUserProvider;
use App\Application\UseCase\GetTaskCollection\UserProvider\CurrentUserProviderResult;
use Ramsey\Uuid\Uuid;

/**
 * Class FakeCurrentUserProvider
 * @package App\Infrastructure\UserProvider
 */
class FakeCurrentUserProvider implements CurrentUserProvider
{
    /**
     * @return CurrentUserProviderResult
     */
    public function getCurrentUser(): CurrentUserProviderResult
    {
        $user = new User(Uuid::fromString('d3b9fef1-2452-4819-a6e9-b2fd7417ea44'));

        return new CurrentUserProviderResult($user);
    }
}
