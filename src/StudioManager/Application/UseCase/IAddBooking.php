<?php

declare(strict_types=1);

namespace StudioManager\Application\UseCase;

interface IAddBooking
{
    public function execute(AddBookingCommand $command): AddBookingResponse;
}
