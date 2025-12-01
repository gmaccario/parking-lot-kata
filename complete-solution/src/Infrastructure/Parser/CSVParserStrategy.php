<?php

namespace App\Infrastructure\Parser;

use App\Application\Parser\ParserInterface;

class CSVParserStrategy implements ParserInterface
{
    public function parse(string $input): array
    {
        $data = [];
        $handle = fopen($input, 'r');
        $headers = fgetcsv($handle, 0, ',', '"', '\\');

        while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
            $data[] = array_combine($headers, $row);
        }

        fclose($handle);

        return $data;
    }
}