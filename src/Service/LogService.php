<?php
declare(strict_types=1);

namespace App\Service;

use App\Data\LogCountRequestData;
use App\Entity\Log;
use App\Repository\LogRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

final class LogService implements LogServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private readonly LogRepositoryInterface $logRepository
    ) {

    }

    public function countLogsByFilters(LogCountRequestData $requestData): int
    {
        return $this->logRepository->countLogsByFilters($requestData);
    }

    public function create(Log $log): void
    {
        $this->checkEntityManagerHealth();

        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }

    public function truncate(): void
    {
        $this->logRepository->deleteAllLogs();
    }

    private function checkEntityManagerHealth(): void
    {
        if ($this->entityManager->isOpen() === true) {
            return;
        }

        $this->entityManager = new EntityManager(
            $this->entityManager->getConnection(),
            $this->entityManager->getConfiguration()
        );        
    }
}