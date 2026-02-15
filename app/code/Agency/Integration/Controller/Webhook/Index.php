<?php

declare(strict_types=1);

namespace Agency\Integration\Controller\Webhook;

use Agency\Integration\Model\Config;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;

class Index implements HttpPostActionInterface, CsrfAwareActionInterface
{
    public function __construct(
        private readonly RequestInterface $request,
        private readonly JsonFactory $resultJsonFactory,
        private readonly Config $config,
        private readonly LoggerInterface $logger
    ) {
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        try {
            $content = (string) $this->request->getContent();
            $signature = $this->request->getHeader('X-Signature');

            if (!$this->validateSignature($content, $signature)) {
                $this->logger->warning('Webhook signature validation failed.');
                return $result->setData(['success' => false, 'message' => 'Invalid Signature'])->setHttpResponseCode(401);
            }

            $data = json_decode($content, true);
            $this->logger->info('Webhook received', ['data' => $data]);

            // Process payload (e.g., Update Order Status, Stock Update)
            // For demo, we just acknowledge.

            return $result->setData(['success' => true, 'message' => 'Received']);

        } catch (\Exception $e) {
            $this->logger->error('Webhook exception: ' . $e->getMessage());
            return $result->setData(['success' => false, 'message' => 'Error'])->setHttpResponseCode(500);
        }
    }

    private function validateSignature(string $content, ?string $signature): bool
    {
        if (empty($signature)) {
            return false;
        }

        $expected = hash_hmac('sha256', $content, $this->config->getWebhookSecret());
        return hash_equals($expected, $signature);
    }

    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null; // Skip CSRF check for webhooks
    }

    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true; // Skip CSRF check for webhooks
    }
}
