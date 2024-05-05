<?php
declare(strict_types=1);

namespace App\Data;

use \DateTimeInterface;

final readonly class LogCountRequestData
{
    public function __construct(
        private ?iterable          $serviceNames = null,
        private ?int               $statusCode = null,
        private ?DateTimeInterface $startDate = null,
        private ?DateTimeInterface $endDate = null
    ) {}

    /**
     * @return iterable<string>|null
     */
    public function getServiceNames(): ?iterable
    {
        return $this->serviceNames;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }
}
