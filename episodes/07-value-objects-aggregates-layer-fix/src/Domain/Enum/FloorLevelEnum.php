<?php

namespace App\Domain\Enum;

enum FloorLevelEnum: int
{
    case GROUND = 0;
    case FIRST = 1;
    case SECOND = 2;
    case THIRD = 3;
    case FOURTH = 4;
}
