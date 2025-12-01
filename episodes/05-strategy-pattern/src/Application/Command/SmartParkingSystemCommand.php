<?php

namespace App\Application\Command;

use App\Domain\Entity\Car;
use App\Domain\Entity\Motorcycle;
use App\Domain\Entity\ParkingFloor;
use App\Domain\Entity\ParkingGarage;
use App\Domain\Entity\Van;
use App\Domain\Enum\FloorLevelEnum;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:smart-parking-system',
    description: '🚗 Welcome to the Smart Parking System!'
)]
class SmartParkingSystemCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $floors = [
            FloorLevelEnum::GROUND->value => new ParkingFloor(2.0),
            FloorLevelEnum::FIRST->value => new ParkingFloor(6.0),
            FloorLevelEnum::SECOND->value => new ParkingFloor(10.0),
        ];

        $garage = new ParkingGarage($floors);

        $io->title('🚗 Welcome to the Smart Parking System!');
        $io->text('Press CTRL+C to exit');
        $io->writeln(str_repeat('-', 40));

        $helper = $this->getHelper('question');

        while (true) {
            $io->newLine();
            $question = new Question('What vehicle is entering? (car/van/motorcycle): ');
            $question->setAutocompleterValues(['car', 'van', 'motorcycle']);

            $answer = strtolower(trim((string) $helper->ask($input, $output, $question)));

            $vehicle = match ($answer) {
                'car' => new Car(),
                'van' => new Van(),
                'motorcycle' => new Motorcycle(),
                default => null,
            };

            if (null === $vehicle) {
                $io->error('Invalid type. Please enter: car, van, or motorcycle.');
                continue;
            }

            try {
                $floor = $garage->park($vehicle);

                $floorName = match (array_search($floor, $floors, true)) {
                    FloorLevelEnum::GROUND->value => 'ground floor',
                    FloorLevelEnum::FIRST->value => 'first floor',
                    FloorLevelEnum::SECOND->value => 'second floor',
                    default => 'floor',
                };

                $io->info("✅ Welcome! Your {$input} has been parked on the {$floorName}");
            } catch (\Exception $e) {
                $io->error('❌ '.$e->getMessage());
            }
        }
    }
}
