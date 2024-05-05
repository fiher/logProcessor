<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Data\LogCountRequestData;
use App\Entity\Log;
use App\Repository\LogRepositoryInterface;
use App\Service\LogService;
use App\Service\LogServiceInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class LogDataManagerTest extends KernelTestCase
{
    private MockObject|EntityManagerInterface $entityManager;

    private MockObject|LogRepositoryInterface $logRepository;

    private LogServiceInterface $dataManager;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->logRepository = $this->createMock(LogRepositoryInterface::class);
        $this->dataManager = new LogService($this->entityManager, $this->logRepository);
    }

    public function testCountLogsByFilters(): void
    {
        $requestData = new LogCountRequestData(statusCode: 201);
        
        $this->logRepository
            ->expects($this->once())
            ->method('countLogsByFilters')
            ->with($requestData)
            ->willReturn(1);

        $this->dataManager->countLogsByFilters($requestData);
    }

    public function testCreate(): void
    {
        $log = new Log();
        $log
            ->setServiceName('random service')
            ->setTimestamp(new DateTime('now'))
            ->setRequestMethod('PUT')
            ->setRequestUri('/ HTTP/1.1')
            ->setStatusCode(201);

        $this->entityManager
            ->expects($this->once())
            ->method('isOpen')
            ->willReturn(true);

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($log);

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $this->dataManager->create($log);
    }


    public function testTruncate(): void
    {
        $this->logRepository
            ->expects($this->once())
            ->method('deleteAllLogs');

        $this->dataManager->truncate();      
    }
}