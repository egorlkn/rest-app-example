<?php declare(strict_types=1);

namespace App\Entry\Api;

use App\Application\UseCase\UpdateTask\UpdateTask as UpdateTaskUseCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateTask
 * @package App\Entry\Api
 */
class UpdateTask extends AbstractController
{
    /**
     * @var UpdateTaskUseCase
     */
    private UpdateTaskUseCase $useCase;

    /**
     * CreateTask constructor.
     * @param UpdateTaskUseCase $useCase
     */
    public function __construct(UpdateTaskUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/api/1/task/{uuid}/update", methods={"PUT"})
     */
    public function updateTask(Request $request): JsonResponse
    {
        $taskId = (string)$request->get('uuid');
        $newTaskName = (string)$request->get('name');

        if (!Uuid::isValid($taskId)) {
            return $this->create404Response();
        }

        $updateTaskResult = $this->useCase->updateTask(Uuid::fromString($taskId), $newTaskName);

        if ($updateTaskResult->isSuccessful()) {
            return new JsonResponse($updateTaskResult->getTask()->toArray());
        }

        return $this->create404Response();
    }

    /**
     * @return JsonResponse
     */
    private function create404Response(): JsonResponse
    {
        return new JsonResponse('Task is not found', 404);
    }
}
