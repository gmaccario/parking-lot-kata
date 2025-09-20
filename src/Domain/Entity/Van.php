<?php

namespace App\Domain\Entity;

use App\Domain\Interface\SizableInterface;

class Van implements SizableInterface
{
    public function getSize(): float
    {
        return 1.5;
    }
}