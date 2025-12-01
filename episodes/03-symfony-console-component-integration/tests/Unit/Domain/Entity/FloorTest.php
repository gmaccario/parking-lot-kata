<?php

namespace Tests\Unit\Domain\Entity;

use App\Domain\Entity\Car;
use App\Domain\Entity\Motorcycle;
use App\Domain\Entity\ParkingFloor;
use App\Domain\Exception\NegativeCapacityNotAllowedException;
use PHPUnit\Framework\TestCase;

class FloorTest extends TestCase
{
    public function testFloorCanBeCreatedWithDefaultValues(): void
    {
        $floor = new ParkingFloor();

        $this->assertInstanceOf(ParkingFloor::class, $floor);
    }

    public function testFloorCanBeCreatedWithCapacity(): void
    {
        $floor = new ParkingFloor(5.0);

        $this->assertInstanceOf(ParkingFloor::class, $floor);
    }

    public function testFloorCanBeCreatedWithNegativeCapacity(): void
    {
        $this->expectException(NegativeCapacityNotAllowedException::class);

        new ParkingFloor(-5.0);
    }

    public function testFloorCanBeCreatedWithCapacityAndCurrentLoad(): void
    {
        $floor = new ParkingFloor(5.0, 2.0);

        $this->assertInstanceOf(ParkingFloor::class, $floor);
    }

    public function testHasSpaceReturnsTrueWhenThereIsSpace(): void
    {
        $floor = new ParkingFloor(5.0);
        $car = new Car();

        $this->assertTrue($floor->hasSpaceFor($car));
    }

    public function testHasSpaceReturnsFalseWhenThereIsNoSpace(): void
    {
        $floor = new ParkingFloor(0.5);
        $car = new Car();

        $this->assertFalse($floor->hasSpaceFor($car));
    }

    public function testHasSpaceReturnsTrueWhenItemFitsExactly(): void
    {
        $floor = new ParkingFloor(1.0);
        $car = new Car();

        $this->assertTrue($floor->hasSpaceFor($car));
    }

    public function testParkUpdatesCurrentLoad(): void
    {
        $floor = new ParkingFloor(5.0);
        $car = new Car();

        // Verify there's space before parking
        $this->assertTrue($floor->hasSpaceFor($car));

        $floor->park($car);

        $anotherCar = new Car();
        $this->assertTrue($floor->hasSpaceFor($anotherCar)); // Should still have space

        // Park multiple items until no space
        $motorcycle1 = new Motorcycle();
        $motorcycle2 = new Motorcycle();
        $motorcycle3 = new Motorcycle();
        $motorcycle4 = new Motorcycle();
        $motorcycle5 = new Motorcycle();
        $motorcycle6 = new Motorcycle();
        $motorcycle7 = new Motorcycle();

        $floor->park($motorcycle1); // Total: 1.5
        $floor->park($motorcycle2); // Total: 2.0
        $floor->park($motorcycle3); // Total: 2.5
        $floor->park($motorcycle4); // Total: 3.0
        $floor->park($motorcycle5); // Total: 3.5
        $floor->park($motorcycle6); // Total: 4.0
        $floor->park($motorcycle7); // Total: 4.5

        // Now there should be 0.5 space left, not enough for a car
        $this->assertFalse($floor->hasSpaceFor($anotherCar));
    }
}
