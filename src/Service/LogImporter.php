<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\LogParserInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class LogImporter implements LogImporterInterface
{
    public function __construct (
        private LogParserInterface $logParser,
        private MessageBusInterface $messageBus
    ) {}

    /**
     * @inheritDoc
     */
    public function importLocalLogFile(?string $filePath = null): void
    {
        $filePath = $filePath ?? '/app/public/logs/logs.log';

        $logsData = $this->logParser->parseLocalFile($filePath);

        foreach ($logsData as $logData) {
            $this->messageBus->dispatch($logData);
        }
    }
}
