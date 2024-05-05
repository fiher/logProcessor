<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\LogMapperInterface;

final class LogParser implements LogParserInterface
{
    public function __construct(private LogMapperInterface $logMapper) {}

    /**
     * @inheritDoc
     */
    public function parseLocalFile(string $filePath): iterable
    {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lines = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $lines);

        $parsedLogData = [];
        foreach ($lines as $line) {
            $parts = explode(' ', $line);

            $parsedLog = $this->logMapper->map($parts);

            $parsedLogData[] = $parsedLog;
        }

        return $parsedLogData;
    }
}
