<?php
declare(strict_types=1);

namespace Agency\Core\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Environment implements OptionSourceInterface
{
    public const PRODUCTION = 'prod';
    public const STAGING = 'stage';
    public const DEVELOPMENT = 'dev';

    /**
     * @return array<int, array<string, string>>
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::PRODUCTION, 'label' => __('Production')],
            ['value' => self::STAGING, 'label' => __('Staging')],
            ['value' => self::DEVELOPMENT, 'label' => __('Development')],
        ];
    }
}
