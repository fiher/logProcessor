<?php
declare(strict_types=1);

namespace App\Message;

use App\Entity\Log;
use App\Service\LogServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class LogDataHandler
{
    public function __construct(private LogServiceInterface $logService) {}

    public function __invoke(LogData $logData): void
    {
        $log = (new Log())
            ->setServiceName($logData->getServiceName())
            ->setTimestamp($logData->getTimestamp())
            ->setRequestMethod($logData->getRequestMethod())
            ->setRequestUri($logData->getRequestUri())
            ->setStatusCode($logData->getStatusCode());

        $this->logService->create($log);
    }
}