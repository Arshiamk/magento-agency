<?php

declare(strict_types=1);

namespace Agency\Integration\Api\Data;

interface IntegrationResultInterface
{
    public const STATUS_SUCCESS = 'success';
    public const STATUS_ERROR = 'error';

    /**
     * Get execution status.
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Get result message.
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Get raw response code/data if available.
     *
     * @return string|null
     */
    public function getRawData(): ?string;
}
