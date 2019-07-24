<?php

declare(strict_types=1);

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use StudioManager\Application\UseCase;
use StudioManager\Application\UseCase\AddBookingResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class BookingsController extends ApiController
{
    /**
     * @var UseCase\IAddBooking
     */
    private $addBookingUseCase;

    public function __construct(UseCase\IAddBooking $addBookingUseCase)
    {
        $this->addBookingUseCase = $addBookingUseCase;
    }

    public function getBookingsAction($uid)
    {
        //not implemented yet
    }

    /**
     *  @ParamConverter("addBookingCommand", converter="fos_rest.request_body")
     */
    public function postBookingsAction(
        UseCase\AddBookingCommand $addBookingCommand,
        ConstraintViolationListInterface $validationErrors
    ) {
        try {
            if($validationErrors->count()) {
                return $this->prepareValidationErrorsResponse($validationErrors);
            }

            $booking = $this->addBookingUseCase->execute($addBookingCommand);

            return $this->preparePostSuccessResponse($booking, $this->prepareLocationHeader($booking));
        } catch (\Error $error) {
            $this->logError($error);
            throw new \RuntimeException('Internal error');
        }
    }

    private function prepareLocationHeader(AddBookingResponse $booking)
    {
        return $this->generateUrl(
            'bookings_get',
            [
                'uid' => $booking->bookingUid
            ]
        );
    }
}

