<?php declare(strict_types=1);

namespace App\Entry\Api;

use App\Application\UseCase\RenameTask\RenameTask as RenameTaskUseCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RenameTask
 * @package App\Entry\Api
 */
class RenameTask extends AbstractController
{
    /**
     * @var RenameTaskUseCase
     */
    private RenameTaskUseCase $useCase;

    /**
     * RenameTask constructor.
     * @param RenameTaskUseCase $useCase
     */
    public function __construct(RenameTaskUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/api/1/task/{uuid}/rename", methods={"PUT"})
     */
    public function renameTask(Request $request): JsonResponse
    {
        $taskUuid = (string)$request->get('uuid');
        $newTaskName = (string)$request->get('name');

        if (!Uuid::isValid($taskUuid)) {
            return $this->create404Response();
        }

        $renameTaskResult = $this->useCase->renameTask(Uuid::fromString($taskUuid), $newTaskName);

        if ($renameTaskResult->isSuccessful()) {
            return new JsonResponse($renameTaskResult->getTask()->toArray());
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
