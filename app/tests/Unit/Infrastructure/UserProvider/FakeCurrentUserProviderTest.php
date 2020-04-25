<?php declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\UserProvider;

use App\Application\Domain\User;
use App\Infrastructure\UserProvider\FakeCurrentUserProvider;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class FakeCurrentUserProviderTest
 * @package App\Tests\Unit\Infrastructure\UserProvider
 */
class FakeCurrentUserProviderTest extends TestCase
{
    public function testGetCurrentUser(): void
    {
        $provider = new FakeCurrentUserProvider();

        $providerResult = $provider->getCurrentUser();

        $this->assertEquals(
            new User(Uuid::fromString('d3b9fef1-2452-4819-a6e9-b2fd7417ea44')),
            $providerResult->getUser()
        );
    }
}
