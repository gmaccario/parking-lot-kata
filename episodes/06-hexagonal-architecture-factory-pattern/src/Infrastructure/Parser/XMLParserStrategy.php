<?php

namespace App\Infrastructure\Parser;

use App\Application\Parser\ParserInterface;

class XMLParserStrategy implements ParserInterface
{
    /**
     * @throws \Exception
     */
    public function parse(string $input): array
    {
        throw new \Exception('Not implemented');
    }
}