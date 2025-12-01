<?php

namespace App\Application\Parser;

interface ParserInterface
{
    /**
     * @param string $input
     * @return array
     */
    public function parse(string $input): array;
}