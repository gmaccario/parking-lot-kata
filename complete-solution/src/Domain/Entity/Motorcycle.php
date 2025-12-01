<?php

namespace App\Domain\Entity;

use App\Domain\Interface\SizableInterface;

readonly class Motorcycle implements SizableInterface
{
    public function size(): float
    {
        return 0.5;
    }
}
