<?php declare(strict_types=1);

namespace App\Application\UseCase\DeleteTask;

/**
 * Class DeleteTaskResult
 * @package App\Application\UseCase\DeleteTask
 */
class DeleteTaskResult
{
    /**
     * @var bool
     */
    private bool $successful;

    /**
     * @var bool
     */
    private bool $notFound;

    private function __construct() {}

    /**
     * @return self
     */
    public static function createSuccessfulResult(): self
    {
        $result = new self();

        $result->successful = true;
        $result->notFound = false;

        return $result;
    }

    /**
     * @return self
     */
    public static function createNotFoundResult(): self
    {
        $result = new self();

        $result->successful = false;
        $result->notFound = true;

        return $result;
    }

    /**
     * @return self
     */
    public static function createFailedResult(): self
    {
        $result = new self();

        $result->successful = false;
        $result->notFound = false;

        return $result;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->successful;
    }

    /**
     * @return bool
     */
    public function isNotFound(): bool
    {
        return $this->notFound;
    }
}
