<?php declare(strict_types=1);

namespace App\Entry\Api;

use App\Application\UseCase\CreateTask\CreateTask as CreateTaskUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateTask
 * @package App\Entry\Api
 */
class CreateTask extends AbstractController
{
    /**
     * @var CreateTaskUseCase
     */
    private CreateTaskUseCase $useCase;

    /**
     * CreateTask constructor.
     * @param CreateTaskUseCase $useCase
     */
    public function __construct(CreateTaskUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/api/1/task/create", methods={"POST"})
     */
    public function createTask(Request $request): JsonResponse
    {
        $taskName = $request->request->get('name');

        $createTaskResult = $this->useCase->createTask($taskName);

        return new JsonResponse($createTaskResult->getTask()->toArray());
    }
}
