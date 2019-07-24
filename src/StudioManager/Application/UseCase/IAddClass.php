<?php

declare(strict_types=1);

namespace StudioManager\Application\UseCase;

use StudioManager\Domain\StudioClass;

interface IAddClass
{
    public function execute(AddClassCommand $command): StudioClass;
}
