<?php

declare(strict_types=1);

namespace StudioManager\Application\UseCase;

class AddBookingCommand
{
    /**
     * @var string
     */
    public $memberName;

    /**
     * @var string
     */
    public $classDate;
}
