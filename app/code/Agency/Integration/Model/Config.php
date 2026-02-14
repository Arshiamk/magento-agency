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
        // Default secret for demo purposes if not set
        return (string) ($this->scopeConfig->getValue(self::XML_PATH_WEBHOOK_SECRET) ?: 'dummy-secret-123');
    }
}
