<?php

namespace App\Domain\Entity;

use App\Domain\Interface\SizableInterface;

readonly class Van implements SizableInterface
{
    public function size(): float
    {
        return 1.5;
    }
}
