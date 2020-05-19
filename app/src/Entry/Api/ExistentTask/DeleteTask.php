<?php declare(strict_types=1);

namespace App\Entry\Api\ExistentTask;

use App\Application\UseCase\MarkTaskAsDeleted\MarkTaskAsDeleted as MarkTaskAsDeletedUseCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteTask
 * @package App\Entry\Api\ExistentTask
 *
 * @Route(path="/task/{uuid}", name="existent_task_")
 */
class DeleteTask extends AbstractController
{
    /**
     * @var MarkTaskAsDeletedUseCase
     */
    private MarkTaskAsDeletedUseCase $useCase;

    /**
     * DeleteTask constructor.
     * @param MarkTaskAsDeletedUseCase $useCase
     */
    public function __construct(MarkTaskAsDeletedUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route(methods={"DELETE"}, name="delete")
     */
    public function deleteTask(Request $request): Response
    {
        $taskUuid = (string)$request->get('uuid');

        if (!Uuid::isValid($taskUuid)) {
            return $this->create404Response();
        }

        $markTaskResult = $this->useCase->markTaskAsDeleted(Uuid::fromString($taskUuid));

        if (!$markTaskResult->isSuccessful()) {
            return $this->create404Response();
        }

        return (new Response())->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     * @return Response
     */
    private function create404Response(): Response
    {
        return (new Response())->setStatusCode(Response::HTTP_NOT_FOUND);
    }
}
