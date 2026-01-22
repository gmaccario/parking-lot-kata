<?php

namespace Tests\Unit\Domain\Entity;

use App\Domain\Entity\Car;
use App\Domain\Interface\SizableInterface;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    private Car $car;

    protected function setUp(): void
    {
        $this->car = new Car();
    }

    public function testCarImplementsSizableInterface(): void
    {
        $this->assertInstanceOf(SizableInterface::class, $this->car);
    }

    public function testCarReturnsCorrectSize(): void
    {
        $this->assertEquals(1.0, $this->car->size());
    }
}
