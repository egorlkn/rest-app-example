<?php declare(strict_types=1);

namespace App\Entry\Api\TaskList;

use App\Application\UseCase\AddNewTask\AddNewTask as AddNewTaskUseCase;
use App\Application\UseCase\AddNewTask\AddNewTaskRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AddNewTask
 * @package App\Entry\Api\TaskList
 *
 * @Route(path="/tasks", name="task_list_")
 */
class AddNewTask extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var AddNewTaskUseCase
     */
    private AddNewTaskUseCase $useCase;

    /**
     * AddNewTask constructor.
     * @param SerializerInterface $serializer
     * @param AddNewTaskUseCase $useCase
     */
    public function __construct(SerializerInterface $serializer, AddNewTaskUseCase $useCase)
    {
        $this->serializer = $serializer;
        $this->useCase = $useCase;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route(methods={"POST"}, name="add_new_task")
     */
    public function addNewTask(Request $request): JsonResponse
    {
        $addNewTaskRequest = $this->deserializeRequest($request);

        $addNewTaskResult = $this->useCase->addNewTask($addNewTaskRequest);

        return new JsonResponse($addNewTaskResult->getTask()->toArray());
    }

    /**
     * @param Request $request
     * @return object|AddNewTaskRequest
     */
    private function deserializeRequest(Request $request): AddNewTaskRequest
    {
        return $this->serializer->deserialize($request->getContent(), AddNewTaskRequest::class, JsonEncoder::FORMAT);
    }
}
