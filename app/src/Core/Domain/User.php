<?php declare(strict_types=1);

namespace App\Core\Domain;

use Ramsey\Uuid\UuidInterface;

/**
 * Class User
 * @package App\Core\Domain
 */
class User
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * User constructor.
     * @param UuidInterface $id
     */
    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
