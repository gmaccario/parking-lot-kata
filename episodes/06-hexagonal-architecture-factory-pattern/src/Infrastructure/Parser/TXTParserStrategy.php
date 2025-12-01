<?php

namespace App\Infrastructure\Parser;

use App\Application\Parser\ParserInterface;

class TXTParserStrategy implements ParserInterface
{
    public function parse(string $input): array
    {
        return [];
    }
}