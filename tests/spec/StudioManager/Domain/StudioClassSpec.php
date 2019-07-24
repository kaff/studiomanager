<?php

namespace spec\StudioManager\Domain;

use StudioManager\Domain\Exception\InvalidCapacityException;
use StudioManager\Domain\Exception\InvalidNameException;
use PhpSpec\ObjectBehavior;
use StudioManager\Domain\Uid;

class StudioClassSpec extends ObjectBehavior
{
    private const NAME = '__NAME__';
    private const START_DATE = '2020-02-01';
    private const END_DATE = '2020-02-12';
    private const CAPACITY = 10;

    function it_returns_uid() {
        $this->beConstructedWith(
            self::NAME,
            new \DateTime(self::START_DATE),
            new \DateTime(self::END_DATE),
            self::CAPACITY
        );

        $this->getUid()->shouldHaveType(Uid::class);
    }


    function it_returns_name() {
        $this->beConstructedWith(
            self::NAME,
            new \DateTime(self::START_DATE),
            new \DateTime(self::END_DATE),
            self::CAPACITY
        );

        $this->getName()->shouldBe(self::NAME);
    }

    function it_throws_exception_when_given_name_is_empty()
    {
        $this->beConstructedWith(
            '',
            new \DateTime(self::START_DATE),
            new \DateTime(self::END_DATE),
            self::CAPACITY
        );

        $this->shouldThrow(InvalidNameException::class)->duringInstantiation();
    }

    function it_throws_exception_when_given_name_is_longer_than_255_characters()
    {
        $this->beConstructedWith(
            $this->prepareTooLongName(),
            new \DateTime(self::START_DATE),
            new \DateTime(self::END_DATE),
            self::CAPACITY
        );

        $this->shouldThrow(InvalidNameException::class)->duringInstantiation();
    }

    function it_returns_start_date() {
        $this->beConstructedWith(
            self::NAME,
            new \DateTime(self::START_DATE),
            new \DateTime(self::END_DATE),
            self::CAPACITY
        );

        $this->getStartDate()->shouldBeLike(new \DateTime(self::START_DATE));
    }

    function it_returns_end_date() {
        $this->beConstructedWith(
            self::NAME,
            new \DateTime(self::START_DATE),
            new \DateTime(self::END_DATE),
            self::CAPACITY
        );

        $this->getEndDate()->shouldBeLike(new \DateTime(self::END_DATE));
    }

    function it_returns_capacity() {
        $this->beConstructedWith(
            self::NAME,
            new \DateTime(self::START_DATE),
            new \DateTime(self::END_DATE),
            self::CAPACITY
        );

        $this->getCapacity()->shouldBeLike(self::CAPACITY);
    }

    function it_throws_exception_when_given_capacity_is_less_than_0()
    {
        $this->beConstructedWith(
            self::NAME,
            new \DateTime(self::START_DATE),
            new \DateTime(self::END_DATE),
            -1
        );

        $this->shouldThrow(InvalidCapacityException::class)->duringInstantiation();
    }

    private function prepareTooLongName()
    {
        return '__NAME_255_CHARACTERS_NAME_255_CHARACTERS_NAME_255_CHARACTERS_NAME_255_CHARACTERS_NAME_255_CHARACTERS_'
                .'NAME_255_CHARACTERS_NAME_255_CHARACTERS_NAME_255_CHARACTERS_NAME_255_CHARACTERS_NAME_255_CHARACTERS_'
                .'NAME_255_CHARACTERS_NAME_255_CHARACTERS_NAME_255_CHARACTERS_NAME_255_CHARACTERS_NAME_255_CHARACTERS_'
                .'NAME_255_CHARACTERS_NAME_255_CHARACTERS_NAME_255_CHARACTERS_NAME_255_CHARACTERS_NAME_255_CHARACTERS_'
                .'NAME_255_CHARACTERS_NAME_255_CHARACTERS__';
    }
}
