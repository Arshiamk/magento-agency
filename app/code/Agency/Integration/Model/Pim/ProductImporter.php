<?php
declare(strict_types=1);

namespace Agency\Integration\Model\Pim;

use Agency\Integration\Api\Data\IntegrationResultInterface;
use Agency\Integration\Api\Data\IntegrationResultInterfaceFactory;
use Agency\Integration\Api\ProductImportInterface;
use Agency\Integration\Model\Erp\Client;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ProductFactory; // Use Factory to create new products
use Psr\Log\LoggerInterface;

class ProductImporter implements ProductImportInterface
{
    public function __construct(
        private readonly Client $client,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductFactory $productFactory,
        private readonly IntegrationResultInterfaceFactory $resultFactory,
        private readonly LoggerInterface $logger
    ) {
    }

    public function importProducts(): IntegrationResultInterface
    {
        try {
            $products = $this->client->getProducts();
            $count = 0;

            foreach ($products as $pimData) {
                try {
                    $product = $this->productRepository->get($pimData['sku']);
                } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                    $product = $this->productFactory->create();
                    $product->setSku($pimData['sku']);
                    $product->setAttributeSetId(4); // Default attribute set
                    $product->setWebsiteIds([1]); // Default website
                    $product->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE);
                    $product->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
                    $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
                }

                $product->setName($pimData['name']);
                $product->setPrice($pimData['price']);
                $product->setStockData([
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'is_in_stock' => $pimData['qty'] > 0 ? 1 : 0,
                    'qty' => $pimData['qty']
                ]);

                $this->productRepository->save($product);
                $count++;
            }

            /** @var \Agency\Integration\Model\IntegrationResult $result */
            $result = $this->resultFactory->create();
            $result->setData([
                'status' => IntegrationResultInterface::STATUS_SUCCESS,
                'message' => "Imported $count products.",
                'raw_data' => json_encode($products)
            ]);

            return $result;
        } catch (\Exception $e) {
            $this->logger->error('Product Import Exception: ' . $e->getMessage());

            /** @var \Agency\Integration\Model\IntegrationResult $result */
            $result = $this->resultFactory->create();
            $result->setData([
                'status' => IntegrationResultInterface::STATUS_ERROR,
                'message' => $e->getMessage()
            ]);
            return $result;
        }
    }
}
