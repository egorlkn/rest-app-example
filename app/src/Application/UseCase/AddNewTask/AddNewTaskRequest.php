<?php declare(strict_types=1);

namespace App\Application\UseCase\AddNewTask;

/**
 * Class AddNewTaskRequest
 * @package App\Application\UseCase\AddNewTask
 */
class AddNewTaskRequest
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var bool
     */
    private bool $completed;

    /**
     * AddNewTaskRequest constructor.
     * @param string $name
     * @param bool $completed
     */
    public function __construct(string $name, bool $completed)
    {
        $this->name = $name;
        $this->completed = $completed;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }
}