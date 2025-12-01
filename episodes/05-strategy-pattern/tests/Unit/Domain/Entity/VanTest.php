<?php

namespace Tests\Unit\Domain\Entity;

use App\Domain\Entity\Van;
use App\Domain\Interface\SizableInterface;
use PHPUnit\Framework\TestCase;

class VanTest extends TestCase
{
    private Van $van;

    protected function setUp(): void
    {
        $this->van = new Van();
    }

    public function testVanImplementsSizableInterface(): void
    {
        $this->assertInstanceOf(SizableInterface::class, $this->van);
    }

    public function testVanReturnsCorrectSize(): void
    {
        $this->assertEquals(1.5, $this->van->size());
    }
}
