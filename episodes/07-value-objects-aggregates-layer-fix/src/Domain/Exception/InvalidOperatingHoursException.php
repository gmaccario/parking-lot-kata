<?php

namespace App\Domain\Exception;

class InvalidOperatingHoursException extends \InvalidArgumentException
{
    protected $message = 'Invalid operating hours.';
}
