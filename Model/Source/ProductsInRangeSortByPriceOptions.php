<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class to supply sort buy options
 */
class ProductsInRangeSortByPriceOptions implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => "asc", 'label' => __('Ascending')],
            ['value' => "desc", 'label' => __('Descending')]
        ];
    }
}
