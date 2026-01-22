<?php

namespace App\Domain\VO;

use App\Domain\Exception\NegativeCapacityNotAllowedException;

readonly class Capacity
{
    public function __construct(
        private float $capacity = 0.0,
    ) {
        if ($this->capacity < 0) {
            throw new NegativeCapacityNotAllowedException();
        }
    }

    public function value(): float
    {
        return $this->capacity;
    }
}
