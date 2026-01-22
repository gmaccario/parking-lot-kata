<?php

namespace App\Domain\Exception;

class InvalidHourException extends \InvalidArgumentException
{
    protected $message = 'Invalid hour.';
}
