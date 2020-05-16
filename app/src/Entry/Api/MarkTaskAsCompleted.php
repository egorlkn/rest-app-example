<?php declare(strict_types=1);

namespace App\Entry\Api;

use App\Application\UseCase\MarkTaskAsCompleted\MarkTaskAsCompleted as MarkTaskAsCompletedUseCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MarkTaskAsCompleted
 * @package App\Entry\Api
 */
class MarkTaskAsCompleted extends AbstractController
{
    /**
     * @var MarkTaskAsCompletedUseCase
     */
    private MarkTaskAsCompletedUseCase $useCase;

    /**
     * MarkTaskAsCompleted constructor.
     * @param MarkTaskAsCompletedUseCase $useCase
     */
    public function __construct(MarkTaskAsCompletedUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/api/1/task/{uuid}/complete", methods={"PUT"})
     */
    public function markTaskAsCompleted(Request $request): JsonResponse
    {
        $taskUuid = (string)$request->get('uuid');

        if (!Uuid::isValid($taskUuid)) {
            return $this->create404Response();
        }

        $markedTaskResult = $this->useCase->markTaskAsCompleted(Uuid::fromString($taskUuid));

        if (!$markedTaskResult->isSuccessful()) {
            return $this->create404Response();
        }

        return new JsonResponse($markedTaskResult->getTask()->toArray());
    }

    /**
     * @return JsonResponse
     */
    private function create404Response(): JsonResponse
    {
        return new JsonResponse('Task is not found', 404);
    }
}
