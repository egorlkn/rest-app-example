<?php declare(strict_types=1);

namespace App\Application\Domain;

use ArrayIterator;
use Webmozart\Assert\Assert;

/**
 * Class TaskCollection
 * @package App\Application\Domain
 *
 * @method Task current()
 * @method Task offsetGet($index)
 * @method Task[] getArrayCopy()
 */
class TaskCollection extends ArrayIterator
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
