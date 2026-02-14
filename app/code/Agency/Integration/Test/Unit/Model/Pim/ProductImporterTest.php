<?php
declare(strict_types=1);

namespace Agency\Integration\Test\Unit\Model\Pim;

use Agency\Integration\Api\Data\IntegrationResultInterface;
use Agency\Integration\Api\Data\IntegrationResultInterfaceFactory;
use Agency\Integration\Model\Erp\Client;
use Agency\Integration\Model\IntegrationResult;
use Agency\Integration\Model\Pim\ProductImporter;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ProductImporterTest extends TestCase
{
    private ProductImporter $importer;
    private Client|MockObject $clientMock;
    private ProductRepositoryInterface|MockObject $productRepoMock;
    private IntegrationResultInterfaceFactory|MockObject $resultFactoryMock;

    protected function setUp(): void
    {
        $this->clientMock = $this->createMock(Client::class);
        $this->productRepoMock = $this->createMock(ProductRepositoryInterface::class);
        $productFactoryMock = $this->getMockBuilder(ProductFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->resultFactoryMock = $this->getMockBuilder(IntegrationResultInterfaceFactory::class)
            ->setMethods(['create'])
            ->getMock();
        $loggerMock = $this->createMock(LoggerInterface::class);

        $this->importer = new ProductImporter(
            $this->clientMock,
            $this->productRepoMock,
            $productFactoryMock,
            $this->resultFactoryMock,
            $loggerMock
        );
    }

    public function testImportProductsSuccessfully()
    {
        $this->clientMock->expects($this->once())
            ->method('getProducts')
            ->willReturn([
                ['sku' => 'SKU1', 'name' => 'Prod 1', 'price' => 10, 'qty' => 5]
            ]);

        $productMock = $this->getMockBuilder(ProductInterface::class)
            ->setMethods(['setName', 'setPrice', 'setStockData', 'save'])
            ->getMockForAbstractClass();

        $this->productRepoMock->expects($this->once())
            ->method('get')
            ->with('SKU1')
            ->willReturn($productMock);

        $this->productRepoMock->expects($this->once())
            ->method('save')
            ->with($productMock);

        $resultMock = new IntegrationResult();
        $this->resultFactoryMock->expects($this->once())->method('create')->willReturn($resultMock);

        $result = $this->importer->importProducts();
        $this->assertEquals(IntegrationResultInterface::STATUS_SUCCESS, $result->getStatus());
    }
}
