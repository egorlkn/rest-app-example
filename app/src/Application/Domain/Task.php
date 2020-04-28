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

    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'name' => $this->name,
        ];
    }
}
