<?php
declare(strict_types=1);

namespace App\Service;

use App\Data\LogCountRequestData;
use App\Entity\Log;

interface LogServiceInterface
{
    public function countLogsByFilters(LogCountRequestData $requestData): int;

    public function create(Log $log): void;

    public function truncate(): void;
}