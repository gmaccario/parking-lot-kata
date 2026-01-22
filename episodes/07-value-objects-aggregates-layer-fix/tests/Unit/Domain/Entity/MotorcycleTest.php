<?php

namespace Tests\Unit\Domain\Entity;

use App\Domain\Entity\Motorcycle;
use App\Domain\Interface\SizableInterface;
use PHPUnit\Framework\TestCase;

class MotorcycleTest extends TestCase
{
    private Motorcycle $motorcycle;

    protected function setUp(): void
    {
        $this->motorcycle = new Motorcycle();
    }

    public function testMotorcycleImplementsSizableInterface(): void
    {
        $this->assertInstanceOf(SizableInterface::class, $this->motorcycle);
    }

    public function testMotorcycleReturnsCorrectSize(): void
    {
        $this->assertEquals(0.5, $this->motorcycle->size());
    }
}
