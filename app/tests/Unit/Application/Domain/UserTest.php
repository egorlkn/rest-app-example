<?php declare(strict_types=1);

namespace App\Tests\Unit\Application\Domain;

use App\Application\Domain\User;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class UserTest
 * @package App\Tests\Unit\Application\Domain
 */
class UserTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetId(): void
    {
        $id = Uuid::uuid4();

        $user = new User($id);

        $this->assertSame($id, $user->getId());
    }
}
