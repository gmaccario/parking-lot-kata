<?php

namespace App\Domain\Entity;

use App\Domain\Enum\FloorEnum;
use App\Domain\Exception\NoSpaceForVanInTheGroundFloorException;
use App\Domain\Exception\NoSpaceInTheGarageException;
use App\Domain\Interface\SizableInterface;

readonly class Garage
{
    public function __construct(
        private array $floors = [],
    ) {}

    /**
     * @throws NoSpaceForVanInTheGroundFloorException
     * @throws NoSpaceInTheGarageException
     */
    public function park(SizableInterface $item): Floor
    {
        if($item instanceof Van) {
            $groundFloor = $this->floors[FloorEnum::GROUND->value];
            if($groundFloor->hasSpace($item)) {
                $groundFloor->park($item);

                return $groundFloor;
            }

            throw new NoSpaceForVanInTheGroundFloorException();
        }

        foreach($this->floors as $floor) {
            if($floor->hasSpace($item)) {
                $floor->park($item);
                return $floor;
            }
        }

        throw new NoSpaceInTheGarageException();
    }
}