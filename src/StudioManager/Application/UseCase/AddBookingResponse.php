<?php

declare(strict_types=1);

namespace StudioManager\Application\UseCase;

class AddBookingResponse
{
    /**
     * @var string
     */
    public $bookingUid;

    /**
     * @var string
     */
    public $memberName;

    /**
     * @var \DateTimeInterface
     */
    public $classDate;

    /**
     * @var string
     */
    public $className;
}
