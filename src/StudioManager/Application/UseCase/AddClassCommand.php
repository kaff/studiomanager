<?php

declare(strict_types=1);

namespace StudioManager\Application\UseCase;

class AddClassCommand
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $startDate;

    /**
     * @var string
     */
    public $endDate;

    /**
     * @var int
     */
    public $capacity;
}
