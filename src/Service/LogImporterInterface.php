<?php
declare(strict_types=1);

namespace App\Service;

interface LogImporterInterface
{
    /**
     * @param string|null $filePath
     * 
     * @return void
     */
    public function importLocalLogFile(?string $filePath = null): void;
}
