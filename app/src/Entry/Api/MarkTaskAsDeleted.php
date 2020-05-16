<?php declare(strict_types=1);

namespace App\Entry\Api;

use App\Application\UseCase\MarkTaskAsDeleted\MarkTaskAsDeleted as MarkTaskAsDeletedUseCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MarkTaskAsDeleted
 * @package App\Entry\Api
 */
class MarkTaskAsDeleted extends AbstractController
{
    /**
     * @var MarkTaskAsDeletedUseCase
     */
    private MarkTaskAsDeletedUseCase $useCase;

    /**
     * MarkTaskAsDeleted constructor.
     * @param MarkTaskAsDeletedUseCase $useCase
     */
    public function __construct(MarkTaskAsDeletedUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/api/1/task/{uuid}/delete", methods={"PUT"})
     */
    public function markTaskAsDeleted(Request $request): JsonResponse
    {
        $taskUuid = (string)$request->get('uuid');

        if (!Uuid::isValid($taskUuid)) {
            return $this->create404Response();
        }

        $markTaskResult = $this->useCase->markTaskAsDeleted(Uuid::fromString($taskUuid));

        if (!$markTaskResult->isSuccessful()) {
            return $this->create404Response();
        }

        return new JsonResponse($markTaskResult->getTask()->toArray());
    }

    /**
     * @return JsonResponse
     */
    private function create404Response(): JsonResponse
    {
        return new JsonResponse('Task is not found', 404);
    }
}
