<?php

declare(strict_types=1);

namespace StudioManager\Domain;

class Booking
{
    /**
     * @var Uid
     */
    private $uid;

    /**
     * @var string
     */
    private $memberName;

    /**
     * @var \DateTimeInterface
     */
    private $classDate;

    public function __construct(string $memberName, \DateTimeInterface $classDate)
    {
        $this->guardMemberName($memberName);

        $this->uid = new Uid();
        $this->memberName = $memberName;
        $this->classDate = $classDate;
    }

    public function getUid(): Uid
    {
        return $this->uid;
    }

    public function getMemberName(): string
    {
        return $this->memberName;
    }

    public function getClassDate(): \DateTimeInterface
    {
        return $this->classDate;
    }

    private function guardMemberName(string $memberName)
    {
        //not implemented yet
        return true;
    }
}
