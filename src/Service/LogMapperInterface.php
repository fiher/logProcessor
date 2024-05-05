<?php
declare(strict_types=1);

namespace App\Service;

use App\Message\LogData;

interface LogMapperInterface
{
    /**
     * @param iterable<mixed> $lines
     * 
     * @return \App\Message\LogData
     */
    public function map(iterable $lines): LogData;
}
