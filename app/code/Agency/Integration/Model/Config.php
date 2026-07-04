<?php

declare(strict_types=1);

namespace Agency\Integration\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const XML_PATH_WEBHOOK_SECRET = 'agency_integration/webhook/secret';

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    public function getWebhookSecret(): string
    {
        // Falls back to a well-known demo secret so webhook signature
        // validation can be exercised out of the box. Production
        // deployments must set agency_integration/webhook/secret.
        return (string) ($this->scopeConfig->getValue(self::XML_PATH_WEBHOOK_SECRET) ?: 'dummy-secret-123');
    }
}
