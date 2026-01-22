<?php

namespace App\Domain\Exception;

class NoSpaceInTheGarageException extends \Exception
{
    protected $message = 'No floor has space for this item.';
}
