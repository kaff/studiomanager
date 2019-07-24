<?php

declare(strict_types=1);

namespace StudioManager\Domain;

use StudioManager\Domain\Exception\InvalidCapacityException;
use StudioManager\Domain\Exception\InvalidNameException;

class StudioClass
{
    /**
     * @var Uid
     */
    private $uid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTimeInterface
     */
    private $startDate;

    /**
     * @var \DateTimeInterface
     */
    private $endDate;

    /**
     * @var int
     */
    private $capacity;

    /**
     * @var Bookings[]
     */
    private $bookings = [];

    public function __construct(
        string $name,
        \DateTimeInterface $startDate,
        \DateTimeInterface $endDate,
        int $capacity
    ) {
        $this->guardName($name);
        $this->guardCapacity($capacity);

        $this->uid = new Uid();
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->capacity = $capacity;
    }

    public function getUid(): Uid
    {
        return $this->uid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function addBooking(Booking $booking)
    {
        $this->bookings[] = $booking;
    }

    private function guardName(string $name)
    {
        if (!$name) {
            throw new InvalidNameException("Name should not be empty.");
        }

        if (strlen($name) > 255) {
            throw new InvalidNameException("Name is too long. It should have less than 255 characters.");
        }
    }

    private function guardCapacity(int $capacity)
    {
        if ($capacity <= 0) {
            throw new InvalidCapacityException("Capacity should be greater than 0.");
        }
    }
}
