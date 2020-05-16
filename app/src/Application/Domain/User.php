<?php declare(strict_types=1);

namespace App\Application\Domain;

use Ramsey\Uuid\UuidInterface;

/**
 * Class User
 * @package App\Application\Domain
 */
class User
{
    /**
     * @var UuidInterface
     */
    private UuidInterface $uuid;

    /**
     * User constructor.
     * @param UuidInterface $uuid
     */
    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }
}
