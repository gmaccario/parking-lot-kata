<?php

namespace Tests\Unit\Command;

use App\Application\Command\ParkingStatusCommand;
use App\Domain\Entity\ParkingGarage;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ParkingStatusCommandTest extends TestCase
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(new ParkingStatusCommand(new ParkingGarage()));

        $command = $application->find('app:parking-status');
        $this->commandTester = new CommandTester($command);
    }

    public function testCommandExecutesSuccessfully(): void
    {
        $this->commandTester->execute([]);

        $this->assertEquals(0, $this->commandTester->getStatusCode());
    }

    public function testCommandOutputContainsParkingStatus(): void
    {
        $this->commandTester->execute([]);

        $output = $this->commandTester->getDisplay();

        $this->assertMatchesRegularExpression(
            '/Parking is (open|closed) now\./',
            $output
        );
    }

    public function testCommandDisplaysInfoMessage(): void
    {
        $this->commandTester->execute([]);

        $output = $this->commandTester->getDisplay();

        // Check that the output is not empty and contains the expected text
        $this->assertNotEmpty($output);
        $this->assertStringContainsString('Parking is', $output);
        $this->assertStringContainsString('now.', $output);
    }
}