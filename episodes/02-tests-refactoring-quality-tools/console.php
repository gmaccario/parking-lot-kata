#!/usr/bin/env php
<?php

require __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

use App\Domain\Entity\Car;
use App\Domain\Entity\Motorcycle;
use App\Domain\Entity\Van;
use App\Domain\Entity\ParkingGarage;
use App\Domain\Entity\ParkingFloor;
use App\Domain\Enum\FloorLevelEnum;

$floors = [
        FloorLevelEnum::GROUND->value => new ParkingFloor(2.0),
        FloorLevelEnum::FIRST->value => new ParkingFloor(6.0),
        FloorLevelEnum::SECOND->value => new ParkingFloor(10.0),
];

$garage = new ParkingGarage($floors);

echo "🚗 Welcome to the Smart Parking System!" . PHP_EOL;
echo "Press CTRL+C to exit" . PHP_EOL;
echo str_repeat("-", 40) . PHP_EOL;

while (true) {
    echo PHP_EOL . "What vehicle is entering? (car/van/motorcycle): ";

    $input = strtolower(trim(fgets(STDIN)));

    $item = match ($input) {
        'car' => new Car(),
        'van' => new Van(),
        'motorcycle' => new Motorcycle(),
        default => null,
    };

    if ($item === null) {
        echo "❌ Invalid type. Please enter: car, van, or motorcycle" . PHP_EOL;
        continue;
    }

    try {
        $floor = $garage->park($item);

        $floorName = match (array_search($floor, $floors, true)) {
            FloorLevelEnum::GROUND->value => 'ground floor',
            FloorLevelEnum::FIRST->value => 'first floor',
            FloorLevelEnum::SECOND->value => 'second floor',
            default => 'floor',
        };

        echo "✅ Welcome! Your {$input} has been parked on the {$floorName}" . PHP_EOL;
    } catch (Exception $e) {
        echo "❌ " . $e->getMessage() . PHP_EOL;
    }
}