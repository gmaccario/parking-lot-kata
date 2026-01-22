<?php

namespace App\Domain\VO;

use App\Domain\Exception\NegativeOccupiedSpaceNotAllowedException;

readonly class OccupiedSpace
{
    public function __construct(
        private float $occupiedSpace = 0.0,
    ) {
        if ($this->occupiedSpace < 0) {
            throw new NegativeOccupiedSpaceNotAllowedException();
        }
    }

    public function value(): float
    {
        return $this->occupiedSpace;
    }

    public function add(float $space): self
    {
        return new self($this->occupiedSpace + $space);
    }
}
