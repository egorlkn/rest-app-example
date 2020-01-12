<?php declare(strict_types=1);

namespace App\Infrastructure\GetTaskCollectionForUser\UserProvider;

use App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider\CurrentUserProvider;
use App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider\CurrentUserProviderResult;
use App\Core\Domain\User;
use Ramsey\Uuid\Uuid;

/**
 * Class FakeCurrentUserProvider
 * @package App\Infrastructure\GetTaskCollectionForUser\UserProvider
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
