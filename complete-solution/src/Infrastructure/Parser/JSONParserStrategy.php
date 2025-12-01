<?php

namespace App\Infrastructure\Parser;

use App\Application\Parser\ParserInterface;

class JSONParserStrategy implements ParserInterface
{
    public function parse(string $input): array
    {
        $content = file_get_contents($input);
        return json_decode($content, true);
    }
}