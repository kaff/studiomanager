<?php

declare(strict_types=1);

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use StudioManager\Application\UseCase;
use StudioManager\Application\UseCase\AddClassCommand;
use StudioManager\Domain\StudioClass;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ClassesController extends ApiController
{
    /**
     * @var UseCase\IAddClass
     */
    private $addClassUseCase;

    public function __construct(UseCase\IAddClass $addClassUseCase)
    {
        $this->addClassUseCase = $addClassUseCase;
    }

    public function getClassesAction($uid)
    {
        //not implemented yet
    }

    /**
     *  @ParamConverter("addClassCommand", converter="fos_rest.request_body")
     */
    public function postClassesAction(
        AddClassCommand $addClassCommand,
        ConstraintViolationListInterface $validationErrors
    ) {
        try {
            if($validationErrors->count()) {
                return $this->prepareValidationErrorsResponse($validationErrors);
            }

            $studioClass = $this->addClassUseCase->execute($addClassCommand);

            return $this->preparePostSuccessResponse($studioClass, $this->prepareLocationHeader($studioClass));
        } catch (\Error $error) {
            $this->logError($error);
            throw new \RuntimeException('Internal error');
        }
    }

    private function prepareLocationHeader(StudioClass $studioClass)
    {
        return $this->generateUrl(
            'classes_get',
            [
                'uid' => $studioClass->getUid()
            ]
        );        
    }
}

