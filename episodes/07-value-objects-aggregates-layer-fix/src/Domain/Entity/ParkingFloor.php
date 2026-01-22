<?php

namespace App\Domain\Entity;

use App\Domain\Interface\SizableInterface;
use App\Domain\VO\Capacity;
use App\Domain\VO\OccupiedSpace;

class ParkingFloor
{
    public function __construct(
        private readonly Capacity $capacity = new Capacity(0.0),
        private OccupiedSpace $occupiedSpace = new OccupiedSpace(0.0),
    ) {}

    public function hasSpaceFor(SizableInterface $item): bool
    {
        return $this->availableSpace() >= $item->size();
    }

    public function park(SizableInterface $item): bool
    {
        if ($this->hasSpaceFor($item)) {
            $this->occupiedSpace = $this->occupiedSpace->add($item->size());

            return true;
        }

        return false;
    }

    private function availableSpace(): float
    {
        return $this->capacity->value() - $this->occupiedSpace->value();
    }
}
