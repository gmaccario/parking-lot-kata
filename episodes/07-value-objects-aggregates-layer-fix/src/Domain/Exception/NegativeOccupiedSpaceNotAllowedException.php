<?php

namespace App\Domain\Exception;

class NegativeOccupiedSpaceNotAllowedException extends \InvalidArgumentException
{
    protected $message = 'Occupied space cannot be negative.';
}
