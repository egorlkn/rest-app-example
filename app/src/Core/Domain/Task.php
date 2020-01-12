<?php declare(strict_types=1);

namespace App\Core\Domain;

use Ramsey\Uuid\UuidInterface;

/**
 * Class Task
 * @package App\Core\Domain
 */
class Task
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var UuidInterface
     */
    private $userId;

    /**
     * Task constructor.
     * @param UuidInterface $id
     * @param string $name
     * @param UuidInterface $userId
     */
    public function __construct(UuidInterface $id, string $name, UuidInterface $userId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'name' => $this->name,
        ];
    }
}
