<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Message\LogData;
use App\Service\LogMapperInterface;
use App\Service\LogParser;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class LogParserTest extends KernelTestCase
{
    public function testParseLocalFile(): void
    {
        $parts = [
            'USER-SERVICE',
            '-', 
            '-', 
            '[18/Aug/2018:10:33:59',
            '+0000]',
            '"POST',
            '/users',
            '201'
        ];

        $serviceName = $parts[0] ?? '';
        $timestamp = new DateTime(\ltrim($parts[3] ?? '', '[') . ' LogParserTest.php' . rtrim($parts[4] ?? '', ']'));
        $requestMethod = $parts[5] ?? '';
        $requestUri = $parts[6] ?? '';
        $responseCode = (int)($parts[8] ?? 0);

        $logData = new LogData(
            $serviceName, 
            $timestamp, 
            $requestMethod, 
            $requestUri,
            $responseCode
        );

        $mapper = $this->createMock(LogMapperInterface::class);
        $mapper
            ->expects($this->once())
            ->method('map')
            ->with($parts)
            ->willReturn($logData);

        $logParser = new LogParser($mapper);

        $parsedLogData = $logParser->parseLocalFile('tests/data/test.log');

        self::assertCount(1, $parsedLogData);
    }
}
