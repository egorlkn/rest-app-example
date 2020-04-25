<?php declare(strict_types=1);

namespace App\Entry\Api;

use App\Application\UseCase\GetTaskCollection\GetTaskCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetTaskList
 * @package App\Entry\Api
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
     * @Route("/api/1/task/list", methods={"GET"})
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
