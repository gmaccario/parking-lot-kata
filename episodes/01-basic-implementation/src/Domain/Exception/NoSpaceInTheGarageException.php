<?php

namespace App\Domain\Exception;

class NoSpaceInTheGarageException extends \Exception
{
    public function __construct()
    {
        parent::__construct('No floor has space for this item.');
    }
}
