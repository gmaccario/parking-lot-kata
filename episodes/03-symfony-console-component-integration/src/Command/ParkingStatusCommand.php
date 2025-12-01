<?php

namespace App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:parking-status',
    description: 'Show true if the parking is open now, false if it is closed.'
)]
class ParkingStatusCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $nowHour  = (int)date('H');

        if($nowHour >= 9 && $nowHour < 23) {
            $io->info('Parking is open now.');
        } else {
            $io->info('Parking is closed now.');
        }

        return Command::SUCCESS;
    }
}