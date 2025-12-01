<?php

namespace App\Application\Command;

use App\Application\UseCase\ImportReservationsUseCase;
use App\Infrastructure\Parser\CSVParserStrategy;
use App\Infrastructure\Parser\JSONParserStrategy;
use App\Infrastructure\Parser\XMLParserStrategy;
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
    private const array EXTENSION_MAP = [
        'csv' => CSVParserStrategy::class,
        'json' => JSONParserStrategy::class,
        'xml' => XMLParserStrategy::class,
    ];

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

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        $strategyClassName = self::EXTENSION_MAP[$extension] ?? null;

        if($strategyClassName === null) {
            $output->writeln('<error>Unsupported file format.</error>');
            return Command::FAILURE;
        }

        $parser = new $strategyClassName();

        new ImportReservationsUseCase($parser)
            ->execute($path);

        return Command::SUCCESS;
    }
}
