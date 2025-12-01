<?php

namespace App\Domain\Exception;

class NoSpaceForVanInTheGroundFloorException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Ground floor has no space for this Van.');
    }
}
