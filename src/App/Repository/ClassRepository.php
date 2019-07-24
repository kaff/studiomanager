<?php

declare(strict_types=1);

namespace App\Repository;

use StudioManager\Domain\StudioClass;
use StudioManager\Infrastructure\StudioClassRepository;

class ClassRepository implements StudioClassRepository
{
    /**
     * @var string
     */
    private $storagePath;

    public function __construct(string $storagePath)
    {
        $this->storagePath = $storagePath;
    }

    public function save(StudioClass $studioClass): StudioClass
    {
        $classes = $this->getFromStorage();
        $classes[(string)$studioClass->getUid()] = $studioClass;

        $this->saveInStorage($classes);

        return $studioClass;
    }

    public function findClassForDate(\DateTimeInterface $date): ?StudioClass
    {
        $storedClasses = $this->getFromStorage();

        $foundClass = array_filter($storedClasses, function (StudioClass $studioClass) use ($date) {
            return $this->isDateInRange($date, $studioClass->getStartDate(), $studioClass->getEndDate());
        });

        return !empty($foundClass) ? reset($foundClass) : null;
    }

    private function isDateInRange(\DateTimeInterface $date, \DateTimeInterface $startDate, \DateTimeInterface $endDate)
    {
        return $date >= $startDate && $date <= $endDate;
    }

    private function saveInStorage($data)
    {
        file_put_contents($this->storagePath, serialize($data));
    }

    private function getFromStorage(): array
    {
        $content = @file_get_contents($this->storagePath);

        if (empty($content)) {
            return [];
        }

        return unserialize($content);
    }
}
