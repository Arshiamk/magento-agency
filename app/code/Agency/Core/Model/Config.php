<?php

declare(strict_types=1);

namespace Agency\Core\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const XML_PATH_ENVIRONMENT = 'agency_core/general/environment';
    private const XML_PATH_DEBUG_LOGGING = 'agency_core/general/debug_logging';

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    public function getEnvironment(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
        return (string) $this->scopeConfig->getValue(
            self::XML_PATH_ENVIRONMENT,
            $scopeType,
            $scopeCode
        );
    }

    public function isDebugLoggingEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return is_string($val = $this->scopeConfig->getValue(
            self::XML_PATH_DEBUG_LOGGING,
            $scopeType,
            $scopeCode
        )) && $val === '1';
    }
}
