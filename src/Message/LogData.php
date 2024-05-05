<?php
declare(strict_types=1);

namespace App\Message;

use DateTimeInterface;

final class LogData
{
    /**
     * @param string $serviceName
     * @param \DateTimeInterface $timestamp
     * @param string $requestMethod
     * @param string $requestUri
     * @param int $statusCode
     */
    public function __construct (
        private readonly string            $serviceName,
        private readonly DateTimeInterface $timestamp,
        private readonly string            $requestMethod,
        private readonly string            $requestUri,
        private readonly int               $statusCode
    ) {}

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function getTimestamp(): DateTimeInterface
    {
        return $this->timestamp;
    }

    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
