<?php declare(strict_types=1);

namespace App\Entry\Api\TaskList;

use App\Application\UseCase\AddNewTask\AddNewTask as AddNewTaskUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation as Http;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @var AddNewTaskUseCase
     */
    private AddNewTaskUseCase $useCase;

    /**
     * AddNewTask constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param AddNewTaskUseCase $useCase
     */
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        AddNewTaskUseCase $useCase
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->useCase = $useCase;
    }

    /**
     * @param Http\Request $httpRequest
     * @return Http\Response|Http\JsonResponse
     *
     * @Route(methods={"POST"}, name="add_new_task")
     */
    public function addNewTask(Http\Request $httpRequest): Http\Response
    {
        try {
            $addNewTaskInputData = $this->createInputData($httpRequest);
        } catch (BadRequestHttpException $e) {
            return (new Http\Response())->setStatusCode(Http\Response::HTTP_BAD_REQUEST);
        }

        $addNewTaskResult = $this->useCase->addNewTask($addNewTaskInputData);

        return new Http\JsonResponse($addNewTaskResult->getTask()->toArray());
    }

    /**
     * @param Http\Request $httpRequest
     * @return AddNewTaskInputData
     * @throws BadRequestHttpException
     */
    private function createInputData(Http\Request $httpRequest): AddNewTaskInputData
    {
        $inputData = $this->deserializeDataFromRequest($httpRequest);

        $this->validateData($inputData);

        return $inputData;
    }

    /**
     * @param Http\Request $request
     * @return object|AddNewTaskInputData
     */
    private function deserializeDataFromRequest(Http\Request $request): AddNewTaskInputData
    {
        return $this->serializer->deserialize($request->getContent(), AddNewTaskInputData::class, JsonEncoder::FORMAT);
    }

    /**
     * @param AddNewTaskInputData $inputData
     * @throws BadRequestHttpException
     */
    private function validateData(AddNewTaskInputData $inputData): void
    {
        $errors = $this->validator->validate($inputData);

        if ($errors->count() > 0) {
            throw new BadRequestHttpException();
        }
    }
}
