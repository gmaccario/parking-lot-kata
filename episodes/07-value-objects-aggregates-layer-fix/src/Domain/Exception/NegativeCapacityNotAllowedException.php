<?php

namespace App\Domain\Exception;

class NegativeCapacityNotAllowedException extends \InvalidArgumentException
{
    protected $message = 'Capacity cannot be negative.';
}
