<?php

namespace App\Domain\Entity;

use App\Domain\Interface\SizableInterface;

class Car implements SizableInterface
{
    public function getSize(): float
    {
        return 1.0;
    }
}