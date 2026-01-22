<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\VO;

use App\Domain\Exception\InvalidHourException;
use App\Domain\Exception\InvalidOperatingHoursException;
use App\Domain\VO\OperatingHours;
use PHPUnit\Framework\TestCase;

class OperatingHoursTest extends TestCase
{
    // ========== CREATION TESTS ==========

    public function testCanBeCreatedWithValidHours(): void
    {
        $hours = new OperatingHours(9, 18);

        $this->assertInstanceOf(OperatingHours::class, $hours);
    }

    public function testCanBeCreatedWithDefaultValues(): void
    {
        $hours = new OperatingHours();

        $this->assertEquals(9, $hours->getOpeningHour());
        $this->assertEquals(23, $hours->getClosingHour());
    }

    public function testCanBeCreatedWithEdgeValidHours(): void
    {
        $hours = new OperatingHours(0, 23);

        $this->assertEquals(0, $hours->getOpeningHour());
        $this->assertEquals(23, $hours->getClosingHour());
    }

    // ========== VALIDATION TESTS ==========

    public function testThrowsExceptionForNegativeOpeningHour(): void
    {
        $this->expectException(InvalidHourException::class);

        new OperatingHours(-1, 18);
    }

    public function testThrowsExceptionForOpeningHourAbove23(): void
    {
        $this->expectException(InvalidHourException::class);

        new OperatingHours(24, 18);
    }

    public function testThrowsExceptionForNegativeClosingHour(): void
    {
        $this->expectException(InvalidHourException::class);

        new OperatingHours(9, -1);
    }

    public function testThrowsExceptionForClosingHourAbove23(): void
    {
        $this->expectException(InvalidHourException::class);

        new OperatingHours(9, 24);
    }

    public function testThrowsExceptionWhenOpeningEqualsClosing(): void
    {
        $this->expectException(InvalidOperatingHoursException::class);

        new OperatingHours(9, 9);
    }

    public function testThrowsExceptionWhenOpeningAfterClosing(): void
    {
        $this->expectException(InvalidOperatingHoursException::class);

        new OperatingHours(18, 9);
    }

    // ========== isOpenAt() TESTS ==========

    public function testIsOpenDuringBusinessHours(): void
    {
        $hours = new OperatingHours(9, 18);

        $this->assertTrue($hours->isOpenAt(new \DateTime('2024-01-15 12:00:00')));
    }

    public function testIsOpenAtExactOpeningTime(): void
    {
        $hours = new OperatingHours(9, 18);

        $this->assertTrue($hours->isOpenAt(new \DateTime('2024-01-15 09:00:00')));
    }

    public function testIsClosedBeforeOpening(): void
    {
        $hours = new OperatingHours(9, 18);

        $this->assertFalse($hours->isOpenAt(new \DateTime('2024-01-15 08:59:59')));
    }

    public function testIsClosedAtExactClosingTime(): void
    {
        $hours = new OperatingHours(9, 18);

        $this->assertFalse($hours->isOpenAt(new \DateTime('2024-01-15 18:00:00')));
    }

    public function testIsClosedAfterClosingTime(): void
    {
        $hours = new OperatingHours(9, 18);

        $this->assertFalse($hours->isOpenAt(new \DateTime('2024-01-15 20:00:00')));
    }

    public function testIsClosedAtMidnight(): void
    {
        $hours = new OperatingHours(9, 18);

        $this->assertFalse($hours->isOpenAt(new \DateTime('2024-01-15 00:00:00')));
    }

    public function testIsOpenAtUsesCurrentTimeWhenNull(): void
    {
        // Open 0-23 so it's almost always open
        $hours = new OperatingHours(0, 23);

        $this->assertTrue($hours->isOpenAt(null));
    }

    // ========== GETTER TESTS ==========

    public function testGetOpeningHour(): void
    {
        $hours = new OperatingHours(8, 20);

        $this->assertEquals(8, $hours->getOpeningHour());
    }

    public function testGetClosingHour(): void
    {
        $hours = new OperatingHours(8, 20);

        $this->assertEquals(20, $hours->getClosingHour());
    }
}
