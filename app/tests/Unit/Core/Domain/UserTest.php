<?php declare(strict_types=1);

namespace App\Tests\Unit\Core\Domain;

use App\Core\Domain\User;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class UserTest
 * @package App\Tests\Unit\Core\Domain
 */
class UserTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test(): void
    {
        $id = Uuid::uuid4();

        $user = new User($id);

        $this->assertSame($id, $user->getId());
    }
}
