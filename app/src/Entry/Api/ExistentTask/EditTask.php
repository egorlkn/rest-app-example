<?php declare(strict_types=1);

namespace App\Entry\Api\ExistentTask;

use App\Application\UseCase\EditTask\EditTask as EditTaskUseCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation as Http;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @var EditTaskUseCase
     */
    private EditTaskUseCase $useCase;

    /**
     * EditTask constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param EditTaskUseCase $useCase
     */
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EditTaskUseCase $useCase
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->useCase = $useCase;
    }

    /**
     * @param Http\Request $httpRequest
     * @return Http\Response|Http\JsonResponse
     *
     * @Route(methods={"PUT"}, name="edit")
     */
    public function editTask(Http\Request $httpRequest): Http\Response
    {
        try {
            $editTaskInputData = $this->createInputData($httpRequest);
        } catch (BadRequestHttpException $e) {
            return $this->create400Response();
        } catch (NotFoundHttpException $e) {
            return $this->create404Response();
        }

        $editTaskResult = $this->useCase->editTask($editTaskInputData);

        if (!$editTaskResult->isSuccessful()) {
            return $this->create404Response();
        }

        return new Http\JsonResponse($editTaskResult->getTask()->toArray());
    }

    /**
     * @param Http\Request $httpRequest
     * @return EditTaskInputData
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     */
    private function createInputData(Http\Request $httpRequest): EditTaskInputData
    {
        $inputData = $this->deserializeDataFromRequest($httpRequest);

        $this->validateData($inputData);

        return $inputData;
    }

    /**
     * @param Http\Request $httpRequest
     * @return EditTaskInputData
     * @throws NotFoundHttpException
     */
    private function deserializeDataFromRequest(Http\Request $httpRequest): EditTaskInputData
    {
        /** @var EditTaskInputData $inputData */
        $inputData = $this->serializer->deserialize(
            $httpRequest->getContent(),
            EditTaskInputData::class,
            JsonEncoder::FORMAT
        );

        $this->setTaskUuidFromRequest($httpRequest, $inputData);

        return $inputData;
    }

    /**
     * @param Http\Request $httpRequest
     * @param EditTaskInputData $inputData
     * @throws NotFoundHttpException
     */
    private function setTaskUuidFromRequest(Http\Request $httpRequest, EditTaskInputData $inputData): void
    {
        $taskUuid = (string)$httpRequest->get('uuid');

        if (!Uuid::isValid($taskUuid)) {
            throw new NotFoundHttpException();
        }

        $inputData->setTaskUuid(Uuid::fromString($taskUuid));
    }

    /**
     * @param EditTaskInputData $inputData
     * @throws BadRequestHttpException
     */
    private function validateData(EditTaskInputData $inputData): void
    {
        $errors = $this->validator->validate($inputData);

        if ($errors->count() > 0) {
            throw new BadRequestHttpException();
        }
    }

    /**
     * @return Http\Response
     */
    private function create400Response(): Http\Response
    {
        return (new Http\Response())->setStatusCode(Http\Response::HTTP_BAD_REQUEST);
    }

    /**
     * @return Http\Response
     */
    private function create404Response(): Http\Response
    {
        return (new Http\Response())->setStatusCode(Http\Response::HTTP_NOT_FOUND);
    }
}
