<?php

namespace App\Application\UseCase;

use App\Application\Parser\ParserInterface;

readonly class ImportReservationsUseCase
{
    public function __construct(
        private ParserInterface $parser
    ) {}

    public function execute(string $input): void
    {
        $data = $this->parser->parse($input);

        foreach ($data as $reservation) {
            // TODO... save into the DB
            print_r($reservation);
        }
    }
}