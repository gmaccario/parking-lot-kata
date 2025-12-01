<?php

namespace App\Domain\Exception;

class NoSpaceForVanInTheGroundFloorException extends \Exception
{
    protected $message = 'Ground floor has no space for this Van.';
}
