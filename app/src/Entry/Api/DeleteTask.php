<?php declare(strict_types=1);

namespace App\Entry\Api;

use App\Application\UseCase\DeleteTask\DeleteTask as DeleteTaskUseCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteTask
 * @package App\Entry\Api
 */
class DeleteTask extends AbstractController
{
    /**
     * @var DeleteTaskUseCase
     */
    private DeleteTaskUseCase $useCase;

    /**
     * DeleteTask constructor.
     * @param DeleteTaskUseCase $useCase
     */
    public function __construct(DeleteTaskUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/api/1/task/{uuid}/delete", methods={"DELETE"})
     */
    public function deleteTask(Request $request): JsonResponse
    {
        $taskUuid = (string)$request->get('uuid');

        if (!Uuid::isValid($taskUuid)) {
            return $this->create404Response();
        }

        $deleteTaskResult = $this->useCase->deleteTask(Uuid::fromString($taskUuid));

        if ($deleteTaskResult->isSuccessful()) {
            return $this->create200Response();
        }

        if ($deleteTaskResult->isNotFound()) {
            return $this->create404Response();
        }

        return $this->create500Response();
    }

    /**
     * @return JsonResponse
     */
    private function create200Response(): JsonResponse
    {
        return new JsonResponse('Task was deleted', 200);
    }

    /**
     * @return JsonResponse
     */
    private function create404Response(): JsonResponse
    {
        return new JsonResponse('Task is not found', 404);
    }

    /**
     * @return JsonResponse
     */
    private function create500Response(): JsonResponse
    {
        return new JsonResponse('Task is not deleted', 500);
    }
}
