<?php

declare(strict_types=1);

namespace StudioManager\Application\UseCase;

use StudioManager\Application\UseCase\Exception\BusyDatesException;
use StudioManager\Domain\StudioClass;
use StudioManager\Infrastructure\StudioClassRepository;

class AddClass implements IAddClass
{
    /**
     * @var StudioClassRepository
     */
    private $repository;

    public function __construct(StudioClassRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(AddClassCommand $command): StudioClass
    {
        if ($this->datesAreNotAvailable($command->startDate, $command->endDate)) {
            throw new BusyDatesException("Given class's dates are busy");
        }

        $studioClass = new StudioClass(
            (string) $command->name,
            new \DateTime($command->startDate),
            new \DateTime($command->endDate),
            (int)$command->capacity
        );

        //The expected response is identical to the object, so I decided to not do mapping here for simplicity.
        return $this->repository->save($studioClass);
    }

    private function datesAreNotAvailable(string $startDate, string $endDate)
    {
        return !$this->datesAreAvailable($startDate, $endDate);
    }

    private function datesAreAvailable(string $startDate, string $endDate)
    {
        $classForStartDate = $this->repository->findClassForDate(
            new \DateTime($startDate)
        );

        $classForEndDate = $this->repository->findClassForDate(
            new \DateTime($endDate)
        );

        return is_null($classForStartDate) && is_null($classForEndDate);
    }
}
