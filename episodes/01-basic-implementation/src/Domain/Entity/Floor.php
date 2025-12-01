<?php

namespace App\Domain\Entity;

use App\Domain\Interface\SizableInterface;

class Floor
{
    public function __construct(
       private readonly float $capacity = 0.0,
       private float          $currentLoad = 0.0,
    ) {}

    public function hasSpace(SizableInterface $item): bool
    {
        return $this->capacity - $this->currentLoad >= $item->getSize();
    }

    public function park(SizableInterface $item): bool
    {
        if($this->hasSpace($item)) {
            $this->currentLoad += $item->getSize();

            return true;
        }

        return false;
    }

    public function leave(SizableInterface $item): void
    {
        $this->currentLoad -= $item->getSize();
    }
}