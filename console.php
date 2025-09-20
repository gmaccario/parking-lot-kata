#!/usr/bin/env php
<?php

require __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

use App\Domain\Entity\Car;
use App\Domain\Entity\Motorcycle;
use App\Domain\Entity\Van;
use App\Domain\Entity\Garage;
use App\Domain\Entity\Floor;

/**
 * Create a garage with 3 floors.
 */
$floors = array_map(function ($capacity) {
    return new Floor($capacity);
}, [2, 6, 10]);

$garage = new Garage($floors);

/**
 * Park a car, a motorcycle and a van.
 */
$items = [new Car(), new Motorcycle(), new Van()];

foreach ($items as $item) {
    try {
        $floor = $garage->park($item);
        echo "Welcome, please go in!".PHP_EOL;
    } catch (Exception $e) {
        echo $e->getMessage().PHP_EOL;
    }
}
