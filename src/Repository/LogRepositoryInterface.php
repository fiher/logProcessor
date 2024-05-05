<?php

namespace App\Repository;

use App\Data\LogCountRequestData;
use App\Entity\Log;

interface LogRepositoryInterface
{
    public function deleteAllLogs(): void;

    public function countLogsByFilters(LogCountRequestData $requestData): int;
}
