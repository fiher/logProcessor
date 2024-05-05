<?php

namespace App\Service;

use App\Data\LogCountRequestData;
use App\Entity\Log;
use DateTime;
use InvalidArgumentException;

class LogValidator implements LogValidatorInterface
{
    public const ERROR_SERVICE_NAMES = 'Service names must be iterable or null.';
    public const ERROR_STATUS_CODE = 'Status code must be an integer or null.';
    public const ERROR_START_DATE = 'Start date must be a timestamp.';
    public const ERROR_END_DATE = 'End date must be a timestamp.';
    public const ERROR_DATE_ORDER = 'End date must be after start date.';

    /**
     * Validates the input data and returns a LogCountRequestData object if valid.
     *
     * @param array $data The data to validate.
     * @return LogCountRequestData|null Returns the LogCountRequestData object or null if validation fails.
     * @throws InvalidArgumentException|\Exception If data types are incorrect or chronological order is invalid.
     */
    public static function validate(array $data): ?LogCountRequestData
    {
        $serviceNames = $data['serviceNames'] ?? null;
        $statusCode = $data['statusCode'] ?? null;
        $startDate = $data['startDate'] ?? null;
        $endDate = $data['endDate'] ?? null;

        if ($serviceNames !== null && !is_array($serviceNames)) {
            throw new InvalidArgumentException(self::ERROR_SERVICE_NAMES);
        }

        if ($statusCode !== null && !is_numeric($statusCode)) {
            throw new InvalidArgumentException(self::ERROR_STATUS_CODE);
        }

        if ($startDate !== null) {
            $startDate = DateTime::createFromFormat(Log::TIMESTAMP_FORMAT, $startDate);

            if ($startDate === false) {
                throw new InvalidArgumentException(self::ERROR_START_DATE);
            }
        }

        if ($endDate !== null) {
            $endDate = DateTime::createFromFormat(Log::TIMESTAMP_FORMAT, $endDate);

            if ($endDate === false) {
                throw new InvalidArgumentException(self::ERROR_END_DATE);
            }
        }

        if ($startDate && $endDate && $endDate < $startDate) {
            throw new InvalidArgumentException(self::ERROR_DATE_ORDER);
        }

        return new LogCountRequestData(
            serviceNames: $serviceNames,
            statusCode: $statusCode,
            startDate: $startDate,
            endDate: $endDate
        );
    }
}