<?php

namespace App\Infrastructure\Parser;

use App\Application\Parser\ParserFactoryInterface;
use App\Application\Parser\ParserInterface;

class ParserFactory implements ParserFactoryInterface
{
    private const array EXTENSION_MAP = [
        'csv' => CSVParserStrategy::class,
        'json' => JSONParserStrategy::class,
        'xml' => XMLParserStrategy::class,
        'txt' => TXTParserStrategy::class,
    ];

    public function createFromFile(string $filePath): ParserInterface
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $strategyClassName = self::EXTENSION_MAP[$extension] ?? null;

        if ($strategyClassName === null) {
            throw new \InvalidArgumentException(
                sprintf('Unsupported file format: %s', $extension)
            );
        };

        return new $strategyClassName();
    }
}