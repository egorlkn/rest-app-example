<?php declare(strict_types=1);

namespace App\Tests\Unit\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider;

use App\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider\CurrentUserProviderResult;
use App\Core\Domain\User;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class CurrentUserProviderResultTest
 * @package App\Tests\Unit\Core\Application\UseCase\GetTaskCollectionForUser\UserProvider
 */
class CurrentUserProviderResultTest extends TestCase
{
    public function test(): void
    {
        /** @var User|MockObject $user */
        $user = $this->createMock(User::class);

        $result = new CurrentUserProviderResult($user);

        $this->assertSame($user, $result->getUser());
    }
}
