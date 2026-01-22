<?php

namespace App\Domain\VO;

use App\Domain\Exception\InvalidHourException;
use App\Domain\Exception\InvalidOperatingHoursException;

readonly class OperatingHours
{
    public function __construct(
        private int $openingHour = 9,
        private int $closingHour = 23,
    ) {
        if ($openingHour < 0 || $openingHour > 23) {
            throw new InvalidHourException('Opening hour must be 0-23');
        }
        if ($closingHour < 0 || $closingHour > 23) {
            throw new InvalidHourException('Closing hour must be 0-23');
        }
        if ($openingHour >= $closingHour) {
            throw new InvalidOperatingHoursException('Opening must be before closing');
        }
    }

    public function isOpenAt(?\DateTimeInterface $datetime = null): bool
    {
        $datetime = $datetime ?? new \DateTime();
        $hour = (int) $datetime->format('H');

        return $hour >= $this->openingHour && $hour < $this->closingHour;
    }

    public function getOpeningHour(): int
    {
        return $this->openingHour;
    }

    public function getClosingHour(): int
    {
        return $this->closingHour;
    }
}
