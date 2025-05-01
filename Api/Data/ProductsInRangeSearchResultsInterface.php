<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

declare(strict_types=1);

namespace CrimsonAgility\ProductsInRange\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface to declare ProductsInRangeSearchResults methods
 */
interface ProductsInRangeSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get ProductsInRange list
     *
     * @return ProductsInRangeInterface[]
     */
    public function getItems(): array;

    /**
     * Set sku list
     *
     * @param ProductsInRangeInterface[] $items
     * @return $this
     */
    public function setItems(array $items): self;
}
