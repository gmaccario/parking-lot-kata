<?php

namespace App\Domain\Entity;

use App\Domain\Interface\SizableInterface;

class Motorcycle implements SizableInterface
{
    public function getSize(): float
    {
        return 0.5;
    }
}