<?php

namespace spec\StudioManager\Application\UseCase;

use StudioManager\Application\UseCase\AddClass;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Argument\Token\CallbackToken;
use StudioManager\Application\UseCase\AddClassCommand;
use StudioManager\Application\UseCase\Exception\BusyDatesException;
use StudioManager\Domain\StudioClass;
use StudioManager\Infrastructure\StudioClassRepository;

class AddClassSpec extends ObjectBehavior
{
    private const NAME = '__NAME__';
    private const START_DATE = '2020-02-01';
    private const END_DATE = '2020-02-12';
    private const CAPACITY = 10;

    function let(StudioClassRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_adds_new_class(StudioClassRepository $repository)
    {
        $expectedStudioClass = new StudioClass(
            self::NAME,
            new \DateTime(self::START_DATE),
            new \DateTime(self::END_DATE),
            self::CAPACITY
        );

        $command = new AddClassCommand();
        $command->name = self::NAME;
        $command->startDate = self::START_DATE;
        $command->endDate = self::END_DATE;
        $command->capacity = self::CAPACITY;

        $repository->findClassForDate(
            new \DateTime(self::START_DATE)
        )->willReturn(null);

        $repository->findClassForDate(
            new \DateTime(self::END_DATE)
        )->willReturn(null);

        $repository->save($this->argumentEqualStudioClass($expectedStudioClass))
            ->willReturn($expectedStudioClass);

        $result = $this->execute($command);

        $result->shouldBeLike($expectedStudioClass);
    }

    function it_throws_exception_when_there_is_another_class_for_given_dates(StudioClassRepository $repository)
    {
        $storedClass = new StudioClass(
            self::NAME,
            new \DateTime(self::START_DATE),
            new \DateTime(self::END_DATE),
            self::CAPACITY
        );

        $command = new AddClassCommand();
        $command->name = self::NAME;
        $command->startDate = self::START_DATE;
        $command->endDate = self::END_DATE;
        $command->capacity = self::CAPACITY;

        $repository->findClassForDate(
            new \DateTime(self::START_DATE)
        )->willReturn($storedClass);

        $repository->findClassForDate(
            new \DateTime(self::END_DATE)
        )->willReturn(null);

        $this->shouldThrow(BusyDatesException::class)->during('execute', [$command]);
    }

    private function argumentEqualStudioClass(StudioClass $expectedStudioClass): CallbackToken {
        return Argument::that(function(StudioClass $param) use ($expectedStudioClass) {
            return $param->getName() == $expectedStudioClass->getName()
                && $param->getStartDate() == $expectedStudioClass->getStartDate()
                && $param->getEndDate() == $expectedStudioClass->getEndDate()
                && $param->getCapacity() == $expectedStudioClass->getCapacity();
        });
    }
}
