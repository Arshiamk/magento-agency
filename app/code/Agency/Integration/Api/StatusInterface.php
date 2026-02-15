<?php

declare(strict_types=1);

namespace Agency\Integration\Api;

interface StatusInterface
{
    /**
     * Get integration status.
     *
     * @return string[]
     */
    public function getStatus(): array;
}
