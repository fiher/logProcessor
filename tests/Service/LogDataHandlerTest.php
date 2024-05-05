<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Log;
use App\Message\LogData;
use App\Message\LogDataHandler;
use App\Service\LogServiceInterface;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


final class LogDataHandlerTest extends KernelTestCase
{
    public function testInvoke(): void
    {
        $logData = new LogData(
            'RANDOM-SERVICE',
            new DateTime('18/Aug/2018:10:33:59 +0000'), 
            'POST', 
            '/users HTTP/1.1',
            201
        );

        $log = (new Log())
            ->setServiceName($logData->getServiceName())
            ->setTimestamp($logData->getTimestamp())
            ->setRequestMethod($logData->getRequestMethod())
            ->setRequestUri($logData->getRequestUri())
            ->setStatusCode($logData->getStatusCode());

        $dataManager = $this->createMock(LogServiceInterface::class);
        $dataManager
            ->expects($this->once())
            ->method('create')
            ->with($log);

        $handler = new LogDataHandler($dataManager);
        $handler->__invoke($logData);
    }
}