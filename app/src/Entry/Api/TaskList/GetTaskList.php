<?php declare(strict_types=1);

namespace App\Entry\Api\TaskList;

use App\Application\UseCase\GetTaskCollection\GetTaskCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetTaskList
 * @package App\Entry\Api\TaskList
 *
 * @Route(path="/tasks", name="task_list_")
 */
class GetTaskList extends AbstractController
{
    /**
     * @var GetTaskCollection
     */
    private GetTaskCollection $useCase;

    /**
     * GetTaskList constructor.
     * @param GetTaskCollection $useCase
     */
    public function __construct(GetTaskCollection $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @return JsonResponse
     *
     * @Route(methods={"GET"}, name="get_task_list")
     */
    public function getTaskList(): JsonResponse
    {
        $getTaskCollectionResult = $this->useCase->getCollection();
        $taskCollection = $getTaskCollectionResult->getTaskCollection();

        $response = [];
        foreach ($taskCollection as $task) {
            $response[] = $task->toArray();
        }

        return new JsonResponse($response);
    }
}
