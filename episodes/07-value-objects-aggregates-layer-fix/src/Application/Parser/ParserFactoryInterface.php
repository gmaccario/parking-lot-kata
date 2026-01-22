<?php

namespace App\Application\Parser;

interface ParserFactoryInterface
{
    /**
     * @throws \InvalidArgumentException if the file format is not supported
     */
    public function createFromFile(string $filePath): ParserInterface;
}
