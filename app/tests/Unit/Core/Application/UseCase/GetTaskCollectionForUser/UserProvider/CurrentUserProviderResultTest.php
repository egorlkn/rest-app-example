<?php declare(strict_types=1);

namespace App\Tests\Unit\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider;

use App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider\CurrentUserProviderResult;
use App\Core\Domain\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class CurrentUserProviderResultTest
 * @package App\Tests\Unit\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider
 */
class CurrentUserProviderResultTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test(): void
    {
        $user = new User(Uuid::uuid4());

        $result = new CurrentUserProviderResult($user);

        $this->assertSame($user, $result->getUser());
    }
}
