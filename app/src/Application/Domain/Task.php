<?php declare(strict_types=1);

namespace App\Application\Domain;

use Ramsey\Uuid\UuidInterface;

/**
 * Class Task
 * @package App\Application\Domain
 */
class Task
{
    /**
     * @var UuidInterface
     */
    private UuidInterface $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var UuidInterface
     */
    private UuidInterface $userId;

    /**
     * @var bool
     */
    private bool $deleted;

    /**
     * Task constructor.
     * @param UuidInterface $id
     * @param string $name
     * @param UuidInterface $userId
     * @param bool $deleted
     */
    public function __construct(UuidInterface $id, string $name, UuidInterface $userId, bool $deleted = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
        $this->deleted = $deleted;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return UuidInterface
     */
    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'name' => $this->name,
        ];
    }
}
