<?php declare(strict_types=1);

namespace App\Tests\Core\Domain;

use App\Core\Domain\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class UserTest
 * @package App\Tests\Core\Domain
 */
class UserTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test(): void
    {
        $id = Uuid::uuid4();

        $user = new User($id);

        $this->assertSame($id, $user->getId());
    }
}
