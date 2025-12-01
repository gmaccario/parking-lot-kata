<?php

namespace App\Application\Command;

use App\Application\UseCase\ImportReservationsUseCase;
use App\Application\Parser\ParserFactoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:parking-import-reservations',
    description: 'Import reservations from different type of files.'
)]
class ParkingImportReservationsCommand extends Command
{
    public function __construct(
        private readonly ParserFactoryInterface $parserFactory,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'path',
            InputArgument::REQUIRED,
            'Path to the file to import'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument('path');

        try {
            $parser = $this->parserFactory->createFromFile($path);
        } catch (\InvalidArgumentException $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            return Command::FAILURE;
        }

        new ImportReservationsUseCase($parser)
            ->execute($path);

        return Command::SUCCESS;
    }
}
