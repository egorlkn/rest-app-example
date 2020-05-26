<?php declare(strict_types=1);

namespace App\Entry\Api\TaskList;

use App\Application\UseCase\AddNewTask as AddNewTaskUseCase;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AddNewTaskInputData
 * @package App\Entry\Api\TaskList
 */
class AddNewTaskInputData implements AddNewTaskUseCase\InputData
{
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
     * @param string $taskName
     * @return AddNewTaskInputData
     */
    public function setTaskName(string $taskName): AddNewTaskInputData
    {
        $this->taskName = $taskName;

        return $this;
    }

    /**
     * @param bool $isCompletedTask
     * @return AddNewTaskInputData
     */
    public function setIsCompletedTask(bool $isCompletedTask): AddNewTaskInputData
    {
        $this->isCompletedTask = $isCompletedTask;

        return $this;
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
