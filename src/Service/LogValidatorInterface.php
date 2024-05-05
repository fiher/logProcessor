<?php

namespace App\Service;

use App\Data\LogCountRequestData;

interface LogValidatorInterface
{
    public static function validate(array $data): ?LogCountRequestData;
}