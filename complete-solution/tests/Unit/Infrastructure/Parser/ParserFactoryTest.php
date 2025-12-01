<?php

namespace Tests\Unit\Infrastructure\Parser;

use App\Infrastructure\Parser\CSVParserStrategy;
use App\Infrastructure\Parser\JSONParserStrategy;
use App\Infrastructure\Parser\ParserFactory;
use App\Infrastructure\Parser\TXTParserStrategy;
use App\Infrastructure\Parser\XMLParserStrategy;
use PHPUnit\Framework\TestCase;

class ParserFactoryTest extends TestCase
{
    private ParserFactory $parserFactory;

    public function setUp(): void
    {
        $this->parserFactory = new ParserFactory();
    }

    public function testCreatesCSVParserForCSVFile(): void
    {
        $parser = $this->parserFactory->createFromFile('./data/parking-reservations.csv');

        $this->assertInstanceOf(CSVParserStrategy::class, $parser);
    }

    public function testCreatesJSONParserForJSONFile(): void
    {
        $parser = $this->parserFactory->createFromFile('./data/parking-reservations.json');

        $this->assertInstanceOf(JSONParserStrategy::class, $parser);
    }

    public function testCreatesXMLParserForXMLFile(): void
    {
        $parser = $this->parserFactory->createFromFile('./data/parking-reservations.xml');

        $this->assertInstanceOf(XMLParserStrategy::class, $parser);
    }

    public function testCreatesXMLParserForTXTFile(): void
    {
        $parser = $this->parserFactory->createFromFile('./data/parking-reservations.txt');

        $this->assertInstanceOf(TXTParserStrategy::class, $parser);
    }

    public function testThrowsExceptionForUnsupportedFileFormat(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported file format');

        $this->parserFactory->createFromFile('./data/parking-reservations.xslx');
    }
}
