<?php

declare(strict_types=1);

namespace StudioManager\Infrastructure;

use StudioManager\Domain\StudioClass;

interface StudioClassRepository
{
    public function save(StudioClass $studioClass): StudioClass;

    public function findClassForDate(\DateTimeInterface $date): ?StudioClass;
}
