<?php
declare(strict_types=1);

namespace App\Repository;

use App\Data\LogCountRequestData;
use App\Entity\Log;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Log>
 *
 * @method Log|null find($id, $lockMode = null, $lockVersion = null)
 * @method Log|null findOneBy(array $criteria, array $orderBy = null)
 * @method Log[]    findAll()
 * @method Log[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class LogRepository extends ServiceEntityRepository implements LogRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Log::class);
    }

    public function deleteAllLogs(): void
    {
        $this
            ->createQueryBuilder('l')
            ->delete()
            ->getQuery()
            ->execute();
    }

    public function countLogsByFilters(LogCountRequestData $requestData): int
    {
        $queryBuilder = $this->createQueryBuilder('l')
            ->select('COUNT(l.id) AS totalLogs');

        if (!empty($requestData->getServiceNames())) {
            $queryBuilder->andWhere('l.serviceName IN (:serviceNames)')
                ->setParameter('serviceNames', $requestData->getServiceNames());
        }

        if ($requestData->getStatusCode() !== null) {
            $queryBuilder->andWhere('l.statusCode = :statusCode')
                ->setParameter('statusCode', $requestData->getStatusCode());
        }

        if ($requestData->getStartDate() !== null) {
            $queryBuilder->andWhere('l.timestamp >= :startDate')
                ->setParameter('startDate', $requestData->getStartDate()->format(Log::TIMESTAMP_FORMAT));
        }

        if ($requestData->getEndDate() !== null) {
            $queryBuilder->andWhere('l.timestamp <= :endDate')
                ->setParameter('endDate', $requestData->getEndDate()->format(Log::TIMESTAMP_FORMAT));
        }

        $result = $queryBuilder->getQuery()->getOneOrNullResult();

        return (int) ($result['totalLogs'] ?? 0);
    }
}
