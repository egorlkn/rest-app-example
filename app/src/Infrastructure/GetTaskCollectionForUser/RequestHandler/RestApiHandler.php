<?php declare(strict_types=1);

namespace App\Infrastructure\GetTaskCollectionForUser\RequestHandler;

use App\Core\Application\UseCase\GetTaskCollectionForUser\GetTaskCollectionForUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RestApiHandler
 * @package App\Infrastructure\GetTaskCollectionForUser\RequestHandler
 */
class RestApiHandler extends AbstractController
{
    /**
     * @var GetTaskCollectionForUser
     */
    private $useCase;

    /**
     * RestApiHandler constructor.
     * @param GetTaskCollectionForUser $useCase
     */
    public function __construct(GetTaskCollectionForUser $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @return JsonResponse
     *
     * @Route("/api/1/task/list", methods={"GET"})
     */
    public function getTaskCollectionForUser(): JsonResponse
    {
        $getTaskCollectionForUserResult = $this->useCase->getCollection();
        $taskCollection = $getTaskCollectionForUserResult->getTaskCollection();

        $response = [];
        foreach ($taskCollection as $task) {
            $response[] = $task->toArray();
        }

        return new JsonResponse($response);
    }
}
