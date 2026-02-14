<?php
declare(strict_types=1);

namespace Agency\Core\Test\Unit\Model;

use Agency\Core\Model\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    private Config $config;
    private ScopeConfigInterface|MockObject $scopeConfigMock;

    protected function setUp(): void
    {
        $this->scopeConfigMock = $this->getMockBuilder(ScopeConfigInterface::class)->getMock();
        $this->config = new Config($this->scopeConfigMock);
    }

    public function testGetEnvironmentReturnsValue()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with('agency_core/general/environment')
            ->willReturn('prod');

        $this->assertEquals('prod', $this->config->getEnvironment());
    }

    public function testIsDebugLoggingEnabledReturnsBool()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with('agency_core/general/debug_logging')
            ->willReturn('1');

        $this->assertTrue($this->config->isDebugLoggingEnabled());
    }
}
