<?php

namespace App\Domain\Entity;

use App\Domain\Enum\FloorLevelEnum;
use App\Domain\Exception\NoSpaceForVanInTheGroundFloorException;
use App\Domain\Exception\NoSpaceInTheGarageException;
use App\Domain\Interface\SizableInterface;

readonly class ParkingGarage
{
    /**
     * @param ParkingFloor[] $floors
     */
    public function __construct(
        private array $floors = [],
    ) {
    }

    /**
     * @throws NoSpaceForVanInTheGroundFloorException
     * @throws NoSpaceInTheGarageException
     */
    public function park(SizableInterface $item): ParkingFloor
    {
        if ($item instanceof Van) {
            return $this->parkVan($item);
        }

        return $this->parkRegularItem($item);
    }

    /**
     * @throws NoSpaceForVanInTheGroundFloorException
     */
    private function parkVan(Van $item): ParkingFloor
    {
        $groundFloor = $this->floors[FloorLevelEnum::GROUND->value];
        if ($groundFloor->hasSpaceFor($item)) {
            $groundFloor->park($item);

            return $groundFloor;
        }

        throw new NoSpaceForVanInTheGroundFloorException();
    }

    /**
     * @throws NoSpaceInTheGarageException
     */
    private function parkRegularItem(SizableInterface $item): ParkingFloor
    {
        foreach ($this->floors as $floor) {
            if ($floor->hasSpaceFor($item)) {
                $floor->park($item);

                return $floor;
            }
        }

        throw new NoSpaceInTheGarageException();
    }
}
