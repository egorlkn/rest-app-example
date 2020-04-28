<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\Component\UserProvider;

use App\Application\Domain\User;
use App\Application\Component\UserProvider\CurrentUserProviderResult;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class CurrentUserProviderResultTest
 * @package App\Tests\Unit\Application\Component\UserProvider
 */
class CurrentUserProviderResultTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test(): void
    {
        $user = new User(Uuid::uuid4());

        $result = new CurrentUserProviderResult($user);

        $this->assertSame($user, $result->getUser());
    }
}
