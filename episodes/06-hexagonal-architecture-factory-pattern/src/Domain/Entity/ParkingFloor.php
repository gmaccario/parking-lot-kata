<?php

namespace App\Domain\Entity;

use App\Domain\Exception\NegativeCapacityNotAllowedException;
use App\Domain\Interface\SizableInterface;

class ParkingFloor
{
    public function __construct(
        private readonly float $capacity = 0.0,
        private float $occupiedSpace = 0.0,
    ) {
        if ($this->capacity < 0) {
            throw new NegativeCapacityNotAllowedException();
        }
    }

    public function hasSpaceFor(SizableInterface $item): bool
    {
        return $this->availableSpace() >= $item->size();
    }

    public function park(SizableInterface $item): bool
    {
        if ($this->hasSpaceFor($item)) {
            $this->occupiedSpace += $item->size();

            return true;
        }

        return false;
    }

    private function availableSpace(): float
    {
        return $this->capacity - $this->occupiedSpace;
    }
}
