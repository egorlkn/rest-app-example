<?php declare(strict_types=1);

namespace App\Core\Domain;

use Webmozart\Assert\Assert;

/**
 * Class TaskCollection
 * @package App\Core\Domain
 *
 * @method Task current()
 * @method Task offsetGet($index)
 * @method Task[] getArrayCopy()
 */
class TaskCollection extends \ArrayIterator
{
    /**
     * TaskCollection constructor.
     * @param array $taskList
     */
    public function __construct(array $taskList = [])
    {
        Assert::allIsInstanceOf($taskList, Task::class);

        parent::__construct($taskList);
    }
}
