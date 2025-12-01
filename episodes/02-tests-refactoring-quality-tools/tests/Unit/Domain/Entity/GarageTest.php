<?php

namespace Tests\Unit\Domain\Entity;

use App\Domain\Entity\Car;
use App\Domain\Entity\Motorcycle;
use App\Domain\Entity\ParkingFloor;
use App\Domain\Entity\ParkingGarage;
use App\Domain\Entity\Van;
use App\Domain\Enum\FloorLevelEnum;
use App\Domain\Exception\NoSpaceForVanInTheGroundFloorException;
use App\Domain\Exception\NoSpaceInTheGarageException;
use PHPUnit\Framework\TestCase;

class GarageTest extends TestCase
{
    public function testGarageCanBeCreatedWithDefaultFloors(): void
    {
        $garage = new ParkingGarage();

        $this->assertInstanceOf(ParkingGarage::class, $garage);
    }

    public function testGarageCanBeCreatedWithFloors(): void
    {
        $floors = [
            FloorLevelEnum::GROUND->value => new ParkingFloor(2.0),
            FloorLevelEnum::FIRST->value => new ParkingFloor(6.0),
            FloorLevelEnum::SECOND->value => new ParkingFloor(10.0),
        ];

        $garage = new ParkingGarage($floors);

        $this->assertInstanceOf(ParkingGarage::class, $garage);
    }

    public function testParkCarInFirstAvailableFloor(): void
    {
        $floors = [
            FloorLevelEnum::GROUND->value => new ParkingFloor(2.0),
            FloorLevelEnum::FIRST->value => new ParkingFloor(6.0),
            FloorLevelEnum::SECOND->value => new ParkingFloor(10.0),
        ];

        $garage = new ParkingGarage($floors);
        $car = new Car();

        $returnedFloor = $garage->park($car);

        $this->assertInstanceOf(ParkingFloor::class, $returnedFloor);
        $this->assertSame($floors[FloorLevelEnum::GROUND->value], $returnedFloor);
    }

    public function testParkMotorcycleInFirstAvailableFloor(): void
    {
        $floors = [
            FloorLevelEnum::GROUND->value => new ParkingFloor(2.0),
            FloorLevelEnum::FIRST->value => new ParkingFloor(6.0),
            FloorLevelEnum::SECOND->value => new ParkingFloor(10.0),
        ];

        $garage = new ParkingGarage($floors);
        $motorcycle = new Motorcycle();

        $returnedFloor = $garage->park($motorcycle);

        $this->assertInstanceOf(ParkingFloor::class, $returnedFloor);
        $this->assertSame($floors[FloorLevelEnum::GROUND->value], $returnedFloor);
    }

    public function testParkVanInGroundFloorOnly(): void
    {
        $floors = [
            FloorLevelEnum::GROUND->value => new ParkingFloor(5.0),
            FloorLevelEnum::FIRST->value => new ParkingFloor(6.0),
            FloorLevelEnum::SECOND->value => new ParkingFloor(10.0),
        ];

        $garage = new ParkingGarage($floors);
        $van = new Van();

        $returnedFloor = $garage->park($van);

        $this->assertInstanceOf(ParkingFloor::class, $returnedFloor);
        $this->assertSame($floors[FloorLevelEnum::GROUND->value], $returnedFloor);
    }

    /**
     * @throws NoSpaceInTheGarageException
     */
    public function testParkVanThrowsExceptionWhenGroundFloorIsFull(): void
    {
        $floors = [
            FloorLevelEnum::GROUND->value => new ParkingFloor(1.0), // Too small for a van
            FloorLevelEnum::FIRST->value => new ParkingFloor(6.0),
            FloorLevelEnum::SECOND->value => new ParkingFloor(10.0),
        ];

        $garage = new ParkingGarage($floors);
        $van = new Van();

        $this->expectException(NoSpaceForVanInTheGroundFloorException::class);

        $garage->park($van);
    }

    /**
     * @throws NoSpaceForVanInTheGroundFloorException
     * @throws NoSpaceInTheGarageException
     */
    public function testParkCarInSecondFloorWhenFirstFloorsAreFull(): void
    {
        $floors = [
            FloorLevelEnum::GROUND->value => new ParkingFloor(0.5), // Too small for a car
            FloorLevelEnum::FIRST->value => new ParkingFloor(0.8),  // Too small for a car
            FloorLevelEnum::SECOND->value => new ParkingFloor(10.0),
        ];

        $garage = new ParkingGarage($floors);
        $car = new Car();

        $returnedFloor = $garage->park($car);

        $this->assertInstanceOf(ParkingFloor::class, $returnedFloor);
        $this->assertSame($floors[FloorLevelEnum::SECOND->value], $returnedFloor);
    }

    /**
     * @throws NoSpaceForVanInTheGroundFloorException
     */
    public function testParkThrowsExceptionWhenNoSpaceInGarage(): void
    {
        $floors = [
            FloorLevelEnum::GROUND->value => new ParkingFloor(0.5),
            FloorLevelEnum::FIRST->value => new ParkingFloor(0.8),
            FloorLevelEnum::SECOND->value => new ParkingFloor(0.9),
        ];

        $garage = new ParkingGarage($floors);
        $car = new Car();

        $this->expectException(NoSpaceInTheGarageException::class);

        $garage->park($car);
    }

    public function testParkMultipleVehiclesInOrder(): void
    {
        $floors = [
            FloorLevelEnum::GROUND->value => new ParkingFloor(3.0),
            FloorLevelEnum::FIRST->value => new ParkingFloor(6.0),
            FloorLevelEnum::SECOND->value => new ParkingFloor(10.0),
        ];

        $garage = new ParkingGarage($floors);

        // Park motorcycle first (goes to ground floor)
        $motorcycle = new Motorcycle();
        $floor = $garage->park($motorcycle);
        $this->assertSame($floors[FloorLevelEnum::GROUND->value], $floor);

        // Park car second (goes to ground floor, total 1.5)
        $car = new Car();
        $floor = $garage->park($car);
        $this->assertSame($floors[FloorLevelEnum::GROUND->value], $floor);

        // Park van (goes to ground floor, total 3.0 - exactly full)
        $van = new Van();
        $floor = $garage->park($van);
        $this->assertSame($floors[FloorLevelEnum::GROUND->value], $floor);

        // Park another car (ground floor is full, goes to first floor)
        $anotherCar = new Car();
        $floor = $garage->park($anotherCar);
        $this->assertSame($floors[FloorLevelEnum::FIRST->value], $floor);
    }
}
