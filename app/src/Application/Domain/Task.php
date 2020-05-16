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
    private UuidInterface $uuid;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var UuidInterface
     */
    private UuidInterface $userUuid;

    /**
     * @var bool
     */
    private bool $completed;

    /**
     * @var bool
     */
    private bool $deleted;

    /**
     * Task constructor.
     * @param UuidInterface $uuid
     * @param string $name
     * @param UuidInterface $userUuid
     * @param bool $completed
     * @param bool $deleted
     */
    public function __construct(
        UuidInterface $uuid,
        string $name,
        UuidInterface $userUuid,
        bool $completed = false,
        bool $deleted = false
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->userUuid = $userUuid;
        $this->completed = $completed;
        $this->deleted = $deleted;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
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
    public function getUserUuid(): UuidInterface
    {
        return $this->userUuid;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
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
            'uuid' => $this->uuid->toString(),
            'name' => $this->name,
            'completed' => $this->completed,
        ];
    }
}
