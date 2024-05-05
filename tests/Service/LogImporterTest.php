<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Log;
use App\Message\LogData;
use App\Service\LogServiceInterface;
use App\Service\LogImporter;
use App\Service\LogImporterInterface;
use App\Service\LogParserInterface;
use DateTime;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;


final class LogImporterTest extends KernelTestCase
{
    private MockObject|LogParserInterface $logParser;

    private MockObject|LogServiceInterface $logDataManager;

    private MockObject|MessageBusInterface $messageBus;

    private LogImporterInterface $logImporter;

    protected function setUp(): void
    {
        $this->logParser = $this->createMock(LogParserInterface::class);
        $this->logDataManager = $this->createMock(LogServiceInterface::class);
        $this->messageBus = $this->createMock(MessageBusInterface::class);

        $this->logImporter = new LogImporter(
            $this->logParser, 
            $this->logDataManager,
            $this->messageBus
        );
    }

    public function testImportLocalLogFileSuccess(): void
    {
        $logData = new LogData(
            'USER-SERVICE', 
            new DateTime('18/Aug/2018:10:33:59 +0000'), 
            'POST', 
            '/users',
            201
        );

        $path = 'tests/data/test.log';

        $this->logParser
            ->expects($this->once())
            ->method('parseLocalFile')
            ->with($path)
            ->willReturn([$logData]);

        $this->messageBus
            ->expects($this->once())
            ->method('dispatch')
            ->with($logData)
            ->willReturn(new Envelope($logData));

        $this->logImporter->importLocalLogFile($path);
    }
}
