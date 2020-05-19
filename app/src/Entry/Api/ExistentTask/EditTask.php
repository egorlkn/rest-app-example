<?php declare(strict_types=1);

namespace App\Entry\Api\ExistentTask;

use App\Application\UseCase\EditTask\EditTask as EditTaskUseCase;
use App\Application\UseCase\EditTask\EditTaskRequest;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class EditTask
 * @package App\Entry\Api\ExistentTask
 *
 * @Route(path="/task/{uuid}", name="existent_task_")
 */
class EditTask extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var EditTaskUseCase
     */
    private EditTaskUseCase $useCase;

    /**
     * EditTask constructor.
     * @param SerializerInterface $serializer
     * @param EditTaskUseCase $useCase
     */
    public function __construct(SerializerInterface $serializer, EditTaskUseCase $useCase)
    {
        $this->serializer = $serializer;
        $this->useCase = $useCase;
    }

    /**
     * @param Request $request
     * @return Response|JsonResponse
     *
     * @Route(methods={"PUT"}, name="edit")
     */
    public function editTask(Request $request): Response
    {
        $taskUuid = (string)$request->get('uuid');

        if (!Uuid::isValid($taskUuid)) {
            return $this->create404Response();
        }

        $editTaskRequest = $this->deserializeRequest($request);

        $editTaskResult = $this->useCase->editTask(Uuid::fromString($taskUuid), $editTaskRequest);

        if (!$editTaskResult->isSuccessful()) {
            return $this->create404Response();
        }

        return new JsonResponse($editTaskResult->getTask()->toArray());
    }

    /**
     * @param Request $request
     * @return object|EditTaskRequest
     */
    private function deserializeRequest(Request $request): EditTaskRequest
    {
        return $this->serializer->deserialize($request->getContent(), EditTaskRequest::class, JsonEncoder::FORMAT);
    }

    /**
     * @return Response
     */
    private function create404Response(): Response
    {
        return (new Response())->setStatusCode(JsonResponse::HTTP_NOT_FOUND);
    }
}
