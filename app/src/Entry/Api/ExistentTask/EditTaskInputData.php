<?php declare(strict_types=1);

namespace App\Entry\Api\ExistentTask;

use App\Application\UseCase\EditTask as EditTaskUseCase;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class EditTaskInputData
 * @package App\Entry\Api\ExistentTask
 */
class EditTaskInputData implements EditTaskUseCase\InputData
{
    /**
     * @var UuidInterface
     *
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    private UuidInterface $taskUuid;

    /**
     * @var string
     *
     * @SerializedName("name")
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private string $taskName;

    /**
     * @var bool
     *
     * @SerializedName("completed")
     *
     * @Assert\Type("bool")
     */
    private bool $isCompletedTask;

    /**
     * @param UuidInterface $taskUuid
     * @return EditTaskInputData
     */
    public function setTaskUuid(UuidInterface $taskUuid): EditTaskInputData
    {
        $this->taskUuid = $taskUuid;

        return $this;
    }

    /**
     * @param string $taskName
     * @return EditTaskInputData
     */
    public function setTaskName(string $taskName): EditTaskInputData
    {
        $this->taskName = $taskName;

        return $this;
    }

    /**
     * @param bool $isCompletedTask
     * @return EditTaskInputData
     */
    public function setIsCompletedTask(bool $isCompletedTask): EditTaskInputData
    {
        $this->isCompletedTask = $isCompletedTask;

        return $this;
    }

    /**
     * @return UuidInterface
     */
    public function getTaskUuid(): UuidInterface
    {
        return $this->taskUuid;
    }

    /**
     * @return string
     */
    public function getTaskName(): string
    {
        return $this->taskName;
    }

    /**
     * @return bool
     */
    public function isCompletedTask(): bool
    {
        return $this->isCompletedTask;
    }
}
