<?php

declare(strict_types=1);

namespace StudioManager\Application\UseCase;

use StudioManager\Application\UseCase\Exception\StudioClassNotFoundDatesException;
use StudioManager\Domain\Booking;
use StudioManager\Domain\StudioClass;
use StudioManager\Infrastructure\StudioClassRepository;

class AddBooking implements IAddBooking
{
    /**
     * @var StudioClassRepository
     */
    private $repository;

    public function __construct(StudioClassRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(AddBookingCommand $command): AddBookingResponse
    {
        $studioClass = $this->repository->findClassForDate(new \DateTime($command->classDate));

        if (is_null($studioClass)) {
            throw new StudioClassNotFoundDatesException('There is not any class for given date.');
        }

        $booking = new Booking(
            (string) $command->memberName,
            new \DateTime($command->classDate)
        );

        $studioClass->addBooking($booking);
        $this->repository->save($studioClass);

        return $this->mapToResponse($booking, $studioClass);
    }

    private function mapToResponse(Booking $booking, StudioClass $studioClass): AddBookingResponse
    {
        $response = new AddBookingResponse();
        $response->bookingUid = (string)$booking->getUid();
        $response->memberName = $booking->getMemberName();
        $response->classDate = $booking->getClassDate();
        $response->className = $studioClass->getName();

        return $response;
    }
}
