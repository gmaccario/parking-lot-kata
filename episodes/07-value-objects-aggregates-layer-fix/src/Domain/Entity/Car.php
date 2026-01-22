<?php

namespace App\Domain\Entity;

use App\Domain\Interface\SizableInterface;

readonly class Car implements SizableInterface
{
    public function size(): float
    {
        return 1.0;
    }
}
