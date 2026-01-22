<?php

namespace App\Application\Parser;

interface ParserInterface
{
    public function parse(string $input): array;
}
